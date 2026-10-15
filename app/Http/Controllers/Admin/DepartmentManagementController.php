<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DepartmentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query()->ordered();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $departments = $query->paginate(10)->withQueryString();

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateDepartment($request);

        $validated['slug'] = Str::slug($validated['name']);

        if (Department::where('slug', $validated['slug'])->exists()) {
            return back()
                ->withErrors(['name' => 'A department with this name already exists.'])
                ->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('departments', 'public');
        }

        unset($validated['image']);

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

public function update(Request $request, Department $department)
{
    $validated = $this->validateDepartment($request);

    $validated['slug'] = Str::slug($validated['name']);

    $duplicate = Department::query()
        ->where('slug', $validated['slug'])
        ->where('id', '!=', $department->id)
        ->exists();

    if ($duplicate) {
        return back()
            ->withErrors([
                'name' => 'A department with this name already exists.',
            ])
            ->withInput();
    }

    $validated['is_active'] = $request->boolean('is_active');
    $validated['sort_order'] = $validated['sort_order'] ?? 0;

    $oldName = $department->name;
    $oldSlug = $department->slug;
    $oldImagePath = $department->image_path;
    $newImagePath = null;

    if ($request->hasFile('image')) {
        $newImagePath = $request->file('image')
            ->store('departments', 'public');

        $validated['image_path'] = $newImagePath;
    }

    unset($validated['image']);

    try {
        DB::transaction(function () use (
            $department,
            $validated,
            $oldName,
            $oldSlug
        ) {
            $department->update($validated);

            // Synchronize existing doctors when a department is renamed.
            if (
                $oldName !== $department->name ||
                $oldSlug !== $department->slug
            ) {
                Doctor::query()
                    ->whereRaw(
                        'LOWER(TRIM(department)) IN (?, ?)',
                        [
                            strtolower(trim($oldName)),
                            strtolower(trim($oldSlug)),
                        ]
                    )
                    ->update([
                        'department' => $department->name,
                    ]);
            }
        });
    } catch (\Throwable $exception) {

        // Remove newly uploaded image if database update fails.
        if ($newImagePath) {
            Storage::disk('public')->delete($newImagePath);
        }

        throw $exception;
    }

    // Delete old image only after database update succeeds.
    if (
        $newImagePath &&
        $oldImagePath &&
        $oldImagePath !== $newImagePath
    ) {
        Storage::disk('public')->delete($oldImagePath);
    }

    return redirect()
        ->route('admin.departments.index')
        ->with(
            'success',
            'Department updated successfully.'
        );


        // Existing doctors store department references as text.
        // Prevent deletion if doctors still belong to this department.
       $linkedDoctors = Doctor::query()
    ->whereRaw('LOWER(TRIM(department)) = ?', [
        strtolower(trim($department->name))
    ])
    ->orWhereRaw('LOWER(TRIM(department)) = ?', [
        strtolower(trim($department->slug))
    ])
    ->exists();

        if ($linkedDoctors) {
            return back()->with(
                'error',
                'This department has linked doctors. Deactivate it instead of deleting.'
            );
        }

        $imagePath = $department->image_path;

        $department->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function toggleStatus(Department $department)
    {
        $department->update([
            'is_active' => !$department->is_active,
        ]);

        return back()->with(
            'success',
            $department->is_active
                ? 'Department activated successfully.'
                : 'Department deactivated successfully.'
        );
    }

    private function validateDepartment(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:10000'],
            'icon' => ['nullable', 'string', 'max:30'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
