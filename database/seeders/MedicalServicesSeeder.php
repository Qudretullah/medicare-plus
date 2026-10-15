<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\WebsiteContentItem;
use Illuminate\Database\Seeder;

class MedicalServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'General Checkup',
                'slug' => 'general-checkup',
                'icon' => '🩺',
                'short_description' => 'Routine health checkups and medical consultations for common illnesses and general health concerns.',
            ],
            [
                'name' => 'Diagnostic Tests',
                'slug' => 'diagnostic-tests',
                'icon' => '🧪',
                'short_description' => 'Reliable diagnostic testing to help doctors identify medical conditions accurately.',
            ],
            [
                'name' => 'Vaccination',
                'slug' => 'vaccination',
                'icon' => '💉',
                'short_description' => 'Safe vaccination services for children, adults and preventive healthcare needs.',
            ],
            [
                'name' => 'Emergency Care',
                'slug' => 'emergency-care',
                'icon' => '🚑',
                'short_description' => 'Quick medical assistance and emergency support for patients who require urgent care.',
            ],
            [
                'name' => 'Specialist Consultation',
                'slug' => 'specialist-consultation',
                'icon' => '👨‍⚕️',
                'short_description' => 'Consult experienced medical specialists for professional diagnosis and treatment.',
            ],
            [
                'name' => 'Preventive Healthcare',
                'slug' => 'preventive-healthcare',
                'icon' => '❤',
                'short_description' => 'Preventive care and health guidance designed to reduce future health risks.',
            ],
        ];

        foreach ($services as $index => $service) {
            $number = $index + 1;

            $savedTitle = WebsiteContentItem::query()
                ->where('page', 'services')
                ->where('content_key', "services_card_{$number}_title")
                ->value('value');

            $savedDescription = WebsiteContentItem::query()
                ->where('page', 'services')
                ->where('content_key', "services_card_{$number}_description")
                ->value('value');

            $name = $savedTitle ?? $service['name'];
            $description = $savedDescription ?? $service['short_description'];

            Service::firstOrCreate(
                ['slug' => $service['slug']],
                [
                    'name' => $name,
                    'short_description' => $description,
                    'icon' => $service['icon'],
                    'description' => $description,
                    'is_active' => true,
                    'sort_order' => $number,
                ]
            );
        }
    }
}
