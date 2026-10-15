<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Throwable;

class ServiceManagementController extends Controller
{
    // All services with search and pagination
    public function index(Request $request)
    {
        $query = Service::query()->ordered();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        $services = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Service::count(),
            'active' => Service::where('is_active', true)->count(),
            'inactive' => Service::where('is_active', false)->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    // Add service form
    public function create()
    {
        return view('admin.services.create');
    }

    // Save new service
    public function store(Request $request)
    {
        $validated = $this->validateService($request);

        $slug = Str::slug($validated['name']);

        if ($slug === '') {
            return back()
                ->withErrors(['name' => 'Enter a valid service name.'])
                ->withInput();
        }

        if (Service::where('slug', $slug)->exists()) {
            return back()
                ->withErrors(['name' => 'A service with this name already exists.'])
                ->withInput();
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('services', 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']);

        try {
            Service::create($validated);
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    // Edit service form
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Update service details
    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request);

        $slug = Str::slug($validated['name']);

        if ($slug === '') {
            return back()
                ->withErrors(['name' => 'Enter a valid service name.'])
                ->withInput();
        }

        $duplicate = Service::query()
            ->where('slug', $slug)
            ->where('id', '!=', $service->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['name' => 'A service with this name already exists.'])
                ->withInput();
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $oldImagePath = $service->image_path;
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')
                ->store('services', 'public');

            $validated['image_path'] = $newImagePath;
        }

        unset($validated['image']);

        try {
            DB::transaction(function () use ($service, $validated) {
                $service->update($validated);
            });
        } catch (Throwable $exception) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $exception;
        }

        if ($newImagePath && $oldImagePath && $oldImagePath !== $newImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    // Delete service
    public function destroy(Service $service)
    {
        $imagePath = $service->image_path;

        $service->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    // Activate or deactivate service
    public function toggleStatus(Service $service)
    {
        $service->update([
            'is_active' => !$service->is_active,
        ]);

        return back()->with(
            'success',
            $service->is_active
                ? 'Service activated successfully.'
                : 'Service deactivated successfully.'
        );
    }

    // Common validation for add and edit forms
    private function validateService(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:10000'],
            'icon' => ['nullable', 'string', 'max:30'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);
    }
}
