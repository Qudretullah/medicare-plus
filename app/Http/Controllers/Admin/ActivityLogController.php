<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:150'],
            'action' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $query = ActivityLog::query()
            ->with('user:id,name')
            ->latest('id');

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        if (!empty($validated['action'])) {
            $query->where('action', $validated['action']);
        }

        if (!empty($validated['date'])) {
            $query->whereDate('created_at', $validated['date']);
        }

        $logs = $query->paginate(15)->withQueryString();

        $actions = ActivityLog::query()
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate(
                'created_at',
                today()
            )->count(),
        ];

        return view(
            'admin.activity-logs.index',
            compact('logs', 'actions', 'stats')
        );
    }
}
