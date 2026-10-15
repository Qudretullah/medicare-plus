<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function show(string $slug): View
    {
        $department = Department::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $doctors = Doctor::query()
            ->where('is_active', true)
            ->where(function ($query) use ($department) {
                $query
                    ->whereRaw(
                        'LOWER(TRIM(department)) = ?',
                        [strtolower(trim($department->name))]
                    )
                    ->orWhereRaw(
                        'LOWER(TRIM(department)) = ?',
                        [strtolower(trim($department->slug))]
                    );
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('departments.show', compact(
            'department',
            'doctors'
        ));
    }
}
