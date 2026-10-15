<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(string $slug): View
    {
        // Current active service
        $service = Service::query()
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Other active services
        $relatedServices = Service::query()
            ->active()
            ->where('id', '!=', $service->id)
            ->ordered()
            ->limit(3)
            ->get();

        return view('services.show', compact(
            'service',
            'relatedServices'
        ));
    }
}
