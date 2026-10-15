<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentRevision;
use App\Models\WebsiteContentItem;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContentRevisionController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
        ]);

        $revisions = ContentRevision::query()
            ->where('model_type', WebsiteContentItem::class)
            ->with('editor:id,name')
            ->when(
                $validated['search'] ?? null,
                function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('action', 'like', "%{$search}%")
                            ->orWhere('model_id', 'like', "%{$search}%");
                    });
                }
            )
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.content-revisions.index',
            compact('revisions')
        );
    }

    public function restore(
        Request $request,
        ContentRevision $revision
    ): RedirectResponse {
        $request->validate([
            'confirm_restore' => ['required', 'accepted'],
        ]);

        if (
            $revision->model_type !== WebsiteContentItem::class ||
            $revision->action !== 'updated'
        ) {
            return back()->with(
                'error',
                'Only CMS update revisions can be restored.'
            );
        }

        $oldValues = $revision->old_values;

        if (
            !is_array($oldValues) ||
            !array_key_exists('value', $oldValues) ||
            !is_string($oldValues['value'])
        ) {
            return back()->with(
                'error',
                'This revision does not contain a restorable content value.'
            );
        }

        $restored = DB::transaction(function () use ($revision, $oldValues) {
            $item = WebsiteContentItem::query()
                ->lockForUpdate()
                ->find($revision->model_id);

            if (!$item) {
                return false;
            }

            
// Verify that this revision still belongs
// to the same CMS page and content key.
$originalValues = $revision->old_values ?? [];
$updatedValues = $revision->new_values ?? [];

if (
    isset($originalValues['content_key']) &&
    $item->content_key !== $originalValues['content_key']
) {
    return false;
}

if (
    isset($updatedValues['content_key']) &&
    $item->content_key !== $updatedValues['content_key']
) {
    return false;
}

if (
    isset($originalValues['page']) &&
    $item->page !== $originalValues['page']
) {
    return false;
}

if (
    isset($updatedValues['page']) &&
    $item->page !== $updatedValues['page']
) {
    return false;
}


            // This prevents accidentally overwriting newer edits.
            $newValues = $revision->new_values;

            if (
                !is_array($newValues) ||
                !array_key_exists('value', $newValues) ||
                $item->value !== $newValues['value']
            ) {
                return false;
            }

            // Normal Eloquent save triggers the revision observer.
            // Therefore a restored value can also be undone later.
            $item->value = $oldValues['value'];
            $item->save();

            return true;
        });

        if (!$restored) {
            return back()->with(
                'error',
                'Restore could not be completed. The content may have changed since this revision.'
            );
        }

        ActivityLogger::record(
            'cms.restored',
            'Admin restored CMS item #' . $revision->model_id
                . ' using revision #' . $revision->id,
            WebsiteContentItem::class,
            $revision->model_id
        );

        return redirect()
            ->route('admin.content-revisions.index')
            ->with('success', 'Previous content restored successfully.');
    }
}
