<?php

namespace App\Providers;
use App\Models\WebsiteContentItem;
use App\Observers\WebsiteContentItemObserver;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        WebsiteContentItem::observe(WebsiteContentItemObserver::class);

        View::composer(
            [
                'partials.navbar',
                'partials.footer',
            ],
            function ($view) {

                $defaults = [
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

                $savedSettings = [];

                if (Schema::hasTable('site_settings')) {
                    $savedSettings = SiteSetting::query()
                        ->pluck('value', 'key')
                        ->all();
                }

                $view->with(
                    'siteSettings',
                    array_merge($defaults, $savedSettings)
                );
            }
        );
    }
}
