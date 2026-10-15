<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Appointment statistics
        $appointmentCounts = Appointment::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalAppointments = $appointmentCounts->sum();

        $pendingAppointments = $appointmentCounts->get('pending', 0);
        $approvedAppointments = $appointmentCounts->get('approved', 0);
        $completedAppointments = $appointmentCounts->get('completed', 0);
        $rejectedAppointments = $appointmentCounts->get('rejected', 0);

        // Clinic management statistics
        $totalDoctors = Doctor::count();
        $totalDepartments = Department::count();
        $totalServices = Service::count();

        // Contact messages statistics
        $totalContactMessages = ContactMessage::count();

        $newContactMessages = ContactMessage::where(
            'status',
            'new'
        )->count();

        // Recent appointments
        $recentAppointments = Appointment::latest()
            ->take(5)
            ->get();

        // Resolve doctor names in one query
        $doctorSlugs = $recentAppointments
            ->pluck('doctor_name')
            ->filter()
            ->unique()
            ->values();

        $doctorNames = Doctor::whereIn('slug', $doctorSlugs)
            ->pluck('name', 'slug');

        return view('admin.dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'completedAppointments',
            'rejectedAppointments',
            'totalDoctors',
            'totalDepartments',
            'totalServices',
            'totalContactMessages',
            'newContactMessages',
            'recentAppointments',
            'doctorNames'
        ));
    }
}
