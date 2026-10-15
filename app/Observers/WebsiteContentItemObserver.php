<?php

namespace App\Observers;

use App\Models\ContentRevision;
use App\Models\WebsiteContentItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebsiteContentItemObserver
{
    public function created(WebsiteContentItem $item): void
    {
        $this->record(
            $item,
            'created',
            null,
            $item->getAttributes()
        );
    }

    public function updated(WebsiteContentItem $item): void
    {
        $changes = $item->getChanges();

        unset($changes['updated_at']);

        if (empty($changes)) {
            return;
        }

        $original = $item->getRawOriginal();

        $oldValues = [];

        foreach ($changes as $key => $newValue) {
            $oldValues[$key] = $item->getOriginal($key);
        }

        $this->record(
            $item,
            'updated',
            $oldValues,
            $changes
        );
    }

    public function deleted(WebsiteContentItem $item): void
    {
        $this->record(
            $item,
            'deleted',
            $item->getAttributes(),
            null
        );
    }

    private function record(
        WebsiteContentItem $item,
        string $action,
        ?array $oldValues,
        ?array $newValues
    ): void {
        if (!Auth::check()) {
            return;
        }

        try {
            ContentRevision::create([
                'model_type' => WebsiteContentItem::class,
                'model_id' => $item->getKey(),
                'action' => $action,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'changed_by' => Auth::id(),
            ]);
        } catch (\Throwable $exception) {
            Log::error('CMS revision logging failed.', [
                'item_id' => $item->getKey(),
                'action' => $action,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
