<?php

namespace Database\Seeders;

use App\Models\WebsiteContentItem;
use Illuminate\Database\Seeder;

class DoctorsDepartmentsContentSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            'doctors' => [
                ['doctors_hero_label', 'text', 'Our Doctors'],
                ['doctors_hero_heading', 'text', 'Meet Our Trusted'],
                ['doctors_hero_highlight', 'text', 'Medical Specialists'],
                ['doctors_hero_description', 'textarea', 'Our experienced doctors are committed to providing professional, compassionate and reliable healthcare across multiple specialties.'],
            ],

            'departments' => [
                ['departments_hero_label', 'text', 'Our Departments'],
                ['departments_hero_heading', 'text', 'Specialized Care For'],
                ['departments_hero_highlight', 'text', 'Every Medical Need'],
                ['departments_hero_description', 'textarea', 'Explore our medical departments and find the right specialists, services and care for your healthcare needs.'],

                ['departments_list_label', 'text', 'Medical Specialties'],
                ['departments_list_heading', 'text', 'Explore Our Departments'],
                ['departments_list_description', 'textarea', 'Choose the right department and get care from experienced specialists.'],

                ['departments_card_1_title', 'text', 'Cardiology'],
                ['departments_card_1_description', 'textarea', 'Diagnosis and treatment for heart, blood pressure and cardiovascular conditions.'],

                ['departments_card_2_title', 'text', 'Neurology'],
                ['departments_card_2_description', 'textarea', 'Specialized care for brain, spine and nervous system conditions.'],

                ['departments_card_3_title', 'text', 'Pediatrics'],
                ['departments_card_3_description', 'textarea', 'Complete healthcare for infants, children and teenagers.'],

                ['departments_card_4_title', 'text', 'Orthopedics'],
                ['departments_card_4_description', 'textarea', 'Professional treatment for bones, joints, muscles and movement problems.'],

                ['departments_card_5_title', 'text', 'Dermatology'],
                ['departments_card_5_description', 'textarea', 'Modern treatment for skin, hair and nail related conditions.'],

                ['departments_card_6_title', 'text', 'General Medicine'],
                ['departments_card_6_description', 'textarea', 'General medical care, health checkups and routine consultations.'],

                ['departments_card_button', 'text', 'View Department'],
            ],
        ];

        foreach ($fields as $page => $items) {
            foreach ($items as [$key, $type, $value]) {
                WebsiteContentItem::firstOrCreate(
                    [
                        'page' => $page,
                        'content_key' => $key,
                    ],
                    [
                        'type' => $type,
                        'value' => $value,
                        'original_value' => $value,
                    ]
                );
            }
        }
    }
}
