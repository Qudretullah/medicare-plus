<?php

namespace App\Http\Controllers\Admin;
use App\Support\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebsiteSettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'appointment_booking_enabled' => SiteSetting::query()
                ->where('key', 'appointment_booking_enabled')
                ->value('value') ?? '1',

            'appointment_notice' => SiteSetting::query()
                ->where('key', 'appointment_notice')
                ->value('value') ?? '',
        ];

        $system = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'app_environment' => app()->environment(),
            'debug_enabled' => config('app.debug'),
            'mail_configured' => filled(config('mail.from.address')),
            'contact_recipient_configured' => filter_var(
                config('mail.contact_recipient'),
                FILTER_VALIDATE_EMAIL
            ) !== false,
        ];

        return view(
            'admin.website-settings.index',
            compact('settings', 'system')
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'appointment_booking_enabled' => [
                'required',
                'boolean',
            ],

            'appointment_notice' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        SiteSetting::updateOrCreate(
            ['key' => 'appointment_booking_enabled'],
            ['value' => $validated['appointment_booking_enabled'] ? '1' : '0']
        );

        SiteSetting::updateOrCreate(
            ['key' => 'appointment_notice'],
            ['value' => $validated['appointment_notice'] ?? '']
        );
        
        
ActivityLogger::record(
    'website_settings.updated',
    'Admin updated appointment booking settings.'
);



        return redirect()
            ->route('admin.website-settings.index')
            ->with('success', 'Website settings updated successfully.');
    }
}
