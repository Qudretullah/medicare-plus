<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedicalDepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Cardiology',
                'icon' => '❤',
                'short_description' => 'Diagnosis and treatment for heart, blood pressure and cardiovascular conditions.',
            ],
            [
                'name' => 'Neurology',
                'icon' => '◉',
                'short_description' => 'Specialized care for brain, spine and nervous system conditions.',
            ],
            [
                'name' => 'Pediatrics',
                'icon' => '⚕',
                'short_description' => 'Complete healthcare for infants, children and teenagers.',
            ],
            [
                'name' => 'Orthopedics',
                'icon' => '🦴',
                'short_description' => 'Professional treatment for bones, joints, muscles and movement problems.',
            ],
            [
                'name' => 'Dermatology',
                'icon' => '✦',
                'short_description' => 'Modern treatment for skin, hair and nail related conditions.',
            ],
            [
                'name' => 'General Medicine',
                'icon' => '✚',
                'short_description' => 'General medical care, health checkups and routine consultations.',
            ],
            [
                'name' => 'Optometry',
                'icon' => '◉',
                'short_description' => 'Professional eye examinations, vision assessment and eye care services.',
            ],
        ];

        foreach ($departments as $index => $item) {
            Department::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'icon' => $item['icon'],
                    'short_description' => $item['short_description'],
                    'description' => $item['short_description'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
