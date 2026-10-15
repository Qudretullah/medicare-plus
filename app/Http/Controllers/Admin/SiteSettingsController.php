<?php

namespace App\Http\Controllers\Admin;
use App\Support\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    private function defaults(): array
    {
        return [
            'site_name' => 'Medicare+',

            'footer_description' =>
                'Medicare+ provides trusted healthcare services, experienced doctors and easy appointment booking for better patient care.',

            'clinic_address_line_1' => '123 Medical Avenue',
            'clinic_address_line_2' => 'Lahore, Pakistan',

            'clinic_phone' => '+92 300 1234567',
            'clinic_email' => 'info@medicareplus.pk',

            'footer_services' =>
                "General Checkup\nCardiology\nPediatrics\nNeurology\nEmergency Care",

            'copyright_text' => 'All Rights Reserved.',

            'facebook_url' => '',
            'instagram_url' => '',
            'linkedin_url' => '',
            'whatsapp_number' => '',

            'site_logo' => '',
        ];
    }

    public function edit(): View
    {
        $settings = array_merge(
            $this->defaults(),
            SiteSetting::query()->pluck('value', 'key')->all()
        );

        return view(
            'admin.site-settings.edit',
            compact('settings')
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => [
                'required', 'string', 'max:100'
            ],

            'footer_description' => [
                'required', 'string', 'max:1000'
            ],

            'clinic_address_line_1' => [
                'required', 'string', 'max:200'
            ],

            'clinic_address_line_2' => [
                'nullable', 'string', 'max:200'
            ],

            'clinic_phone' => [
                'required', 'string', 'max:40'
            ],

            'clinic_email' => [
                'required', 'email', 'max:255'
            ],

            'footer_services' => [
                'nullable', 'string', 'max:2000'
            ],

            'copyright_text' => [
                'required', 'string', 'max:200'
            ],

            'facebook_url' => [
                'nullable', 'url', 'starts_with:https://',
                'max:500'
            ],

            'instagram_url' => [
                'nullable', 'url', 'starts_with:https://',
                'max:500'
            ],

            'linkedin_url' => [
                'nullable', 'url', 'starts_with:https://',
                'max:500'
            ],

            'whatsapp_number' => [
                'nullable', 'string',
                'regex:/^\+?[0-9]{10,15}$/'
            ],

            'site_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'remove_logo' => [
                'nullable', 'boolean'
            ],
        ]);

        $logo = $request->file('site_logo');
        $removeLogo = $request->boolean('remove_logo');

        // Save the new image before changing stored settings.
        $newLogoPath = null;

        if ($logo && !$removeLogo) {
            $newLogoPath = $logo->store(
                'site-logos',
                'public'
            );
        }

        $oldLogoPath = SiteSetting::query()
            ->where('key', 'site_logo')
            ->value('value');

        unset(
            $validated['site_logo'],
            $validated['remove_logo']
        );

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        if ($newLogoPath !== null || $removeLogo) {
            SiteSetting::updateOrCreate(
                ['key' => 'site_logo'],
                [
                    'value' => $removeLogo
                        ? ''
                        : $newLogoPath
                ]
            );

            if (
                $oldLogoPath &&
                $oldLogoPath !== $newLogoPath
            ) {
                Storage::disk('public')->delete(
                    $oldLogoPath
                );
            }

            if ($removeLogo && $newLogoPath) {
                Storage::disk('public')->delete(
                    $newLogoPath
                );
            }
        }
        
        
ActivityLogger::record(
    'site_settings.updated',
    'Admin updated the website navbar, footer or branding settings.'
);



        return redirect()
            ->route('admin.site-settings.edit')
            ->with(
                'success',
                'Navbar and footer settings updated successfully.'
            );
    }
}
