<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\WebsiteContentItem;

class DoctorController extends Controller
{
    public function index()
    {
        // Fetch active doctors from database
        $doctors = Doctor::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // Fetch Doctors Page Editor content
        $contentItems = WebsiteContentItem::query()
            ->where('page', 'doctors')
            ->get()
            ->keyBy('content_key');

        return view('doctors', compact(
            'doctors',
            'contentItems'
        ));
    }

    public function show(string $slug)
    {
        $doctor = Doctor::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedDoctors = Doctor::query()
            ->where('is_active', true)
            ->where('id', '!=', $doctor->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('doctors.show', compact(
            'doctor',
            'relatedDoctors'
        ));
    }
}
