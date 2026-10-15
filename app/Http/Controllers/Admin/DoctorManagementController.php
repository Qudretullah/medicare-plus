<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DoctorManagementController extends Controller
{
    /**
     * All doctors with search and pagination.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $doctors = Doctor::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('specialization', 'like', '%' . $search . '%')
                        ->orWhere('department', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.doctors.index', compact(
            'doctors',
            'search'
        ));
    }

    /**
     * Add Doctor form.
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store new doctor.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $baseSlug = Str::slug($data['name']);

        if ($baseSlug === '') {
            $baseSlug = 'doctor';
        }

        $data['slug'] = $this->generateUniqueSlug($baseSlug);

        $data['is_active'] = $request->boolean('is_active');

        $data['image_path'] = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('doctors', 'public');

            $data['image_path'] = 'storage/' . $path;
        }

        unset($data['image']);

        try {
            Doctor::create($data);
        } catch (\Throwable $exception) {

            if (!empty($path)) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor added successfully.');
    }

    /**
     * Edit Doctor form.
     */
    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update Doctor details.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $data = $this->validatedData($request);

        $data['is_active'] = $request->boolean('is_active');

        // Keep existing slug so bookmarked profile URLs work.
        $data['slug'] = $doctor->slug;

        $oldImage = $doctor->image_path;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('doctors', 'public');

            $data['image_path'] = 'storage/' . $newImage;
        }

        unset($data['image']);

        try {
            $doctor->update($data);
        } catch (\Throwable $exception) {

            if ($newImage !== null) {
                Storage::disk('public')->delete($newImage);
            }

            throw $exception;
        }

        // Delete only old images managed by the upload system.
        // Never delete original public/images/doctor-x.jpg images.
        if (
            $newImage !== null &&
            $oldImage &&
            str_starts_with($oldImage, 'storage/doctors/')
        ) {
            Storage::disk('public')->delete(
                substr($oldImage, strlen('storage/'))
            );
        }

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Activate or deactivate a doctor.
     */
    public function toggleStatus(Doctor $doctor)
    {
        $doctor->is_active = !$doctor->is_active;
        $doctor->save();

        return redirect()
            ->route('admin.doctors.index')
            ->with(
                'success',
                $doctor->is_active
                    ? 'Doctor activated successfully.'
                    : 'Doctor deactivated successfully.'
            );
    }

    /**
     * Shared Add / Edit validation.
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'specialization' => [
                'required',
                'string',
                'max:255',
            ],
            'department' => [
                'nullable',
                'string',
                'max:255',
            ],
            'qualification' => [
                'nullable',
                'string',
                'max:255',
            ],
            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'bio' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:999999',
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);
    }

    /**
     * Create a unique slug for new doctors.
     */
    private function generateUniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $number = 2;

        while (Doctor::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        return $slug;
    }
}
