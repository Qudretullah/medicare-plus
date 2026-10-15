<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentDescriptionsSeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [

            'cardiology' => <<<'TEXT'
Our Cardiology Department focuses on the prevention, evaluation, diagnosis, and management of conditions affecting the heart and cardiovascular system. We aim to help patients understand their heart health through professional medical consultations, individualized care, and appropriate diagnostic assessments.

Cardiovascular health is an important part of overall wellbeing. Our approach includes assessing symptoms such as chest discomfort, shortness of breath, palpitations, and changes in blood pressure. We also emphasize identifying cardiovascular risk factors, including family history, cholesterol levels, diabetes, smoking, and lifestyle habits.

Patients can receive guidance on managing common cardiovascular concerns such as high blood pressure, heart rhythm problems, and other heart-related conditions. Depending on individual needs, a clinician may recommend further testing, ongoing monitoring, treatment, or referral for specialized care.

At Medicare+, we believe that better heart health begins with awareness, early assessment, and consistent follow-up. Our goal is to support patients in making informed decisions and maintaining healthier lives.
TEXT,

            'neurology' => <<<'TEXT'
Our Neurology Department is dedicated to the assessment and management of medical conditions affecting the brain, spinal cord, nerves, and nervous system. Neurological health influences movement, sensation, memory, coordination, and many essential functions of daily life.

We focus on understanding symptoms such as persistent headaches, migraines, dizziness, numbness, weakness, tremors, and other changes in neurological function. A detailed medical history and neurological examination can help determine whether further investigations or specialist treatment are appropriate.

Neurological conditions can vary widely in their causes and severity. Our patient-focused approach emphasizes careful evaluation, clear explanations, appropriate treatment planning, and follow-up care tailored to each individual's needs.

Medicare+ aims to help patients understand their neurological concerns and access appropriate medical guidance. We encourage timely assessment of new or worsening symptoms and support patients throughout their healthcare journey.
TEXT,

            'pediatrics' => <<<'TEXT'
Our Pediatrics Department provides healthcare guidance and medical assessment for infants, children, and adolescents. Children's healthcare needs change as they grow, making regular monitoring, preventive care, and age-appropriate medical support especially important.

We focus on childhood health concerns, including common illnesses, growth and development, nutritional wellbeing, and preventive healthcare. Pediatric consultations may include reviewing medical history, assessing symptoms, monitoring developmental milestones, and discussing recommended immunizations.

We recognize that parents and caregivers play an essential role in children's health. Our approach emphasizes clear communication, practical guidance, and a supportive environment where families can discuss questions about their children's wellbeing.

At Medicare+, our goal is to encourage healthy development and help families make informed healthcare decisions. We support preventive care, early assessment of health concerns, and appropriate follow-up throughout childhood.
TEXT,

            'orthopedics' => <<<'TEXT'
Our Orthopedics Department focuses on health conditions involving the bones, joints, muscles, ligaments, tendons, and musculoskeletal system. These structures are essential for movement, physical activity, and everyday comfort.

We provide medical evaluation for concerns such as joint discomfort, back pain, muscle and ligament injuries, restricted movement, and other musculoskeletal symptoms. Understanding the cause of pain or reduced mobility is an important part of planning appropriate care.

Orthopedic assessment may involve reviewing symptoms, examining affected areas, and considering diagnostic investigations when clinically indicated. Treatment recommendations depend on the specific condition and may involve medication, rehabilitation guidance, activity modification, or specialist referral.

Medicare+ emphasizes patient education, injury prevention, and appropriate follow-up care. Our aim is to support better mobility, physical function, and quality of life through informed medical guidance.
TEXT,

            'dermatology' => <<<'TEXT'
Our Dermatology Department focuses on the evaluation and management of conditions affecting the skin, hair, and nails. Healthy skin plays an important role in protecting the body and contributes to comfort and overall wellbeing.

We address concerns such as acne, eczema, skin irritation, rashes, pigmentation changes, hair and scalp conditions, and other dermatological symptoms. Because skin conditions can have different underlying causes, accurate assessment is important before selecting an appropriate management approach.

Dermatological consultations may include discussing symptoms, examining affected areas, reviewing skincare habits, and recommending suitable treatment or further evaluation where necessary. We emphasize safe, evidence-informed care rather than unverified or potentially harmful skincare practices.

At Medicare+, our approach combines professional medical guidance with patient education. We aim to help individuals better understand their skin concerns and develop practical strategies for maintaining skin health.
TEXT,

            'general-medicine' => <<<'TEXT'
Our General Medicine Department provides medical consultations for a broad range of common health concerns affecting adults. General medical care often serves as the first point of contact for patients seeking advice, symptom assessment, and ongoing health management.

We focus on concerns such as fever, fatigue, respiratory symptoms, digestive problems, blood pressure changes, and general health conditions. Medical consultations may include reviewing symptoms, discussing medical history, performing an examination, and recommending appropriate investigations when needed.

General medicine also plays an important role in preventive healthcare and the ongoing management of chronic conditions such as hypertension and diabetes. Regular follow-up can help patients understand their conditions, review treatment plans, and identify concerns that require additional attention.

At Medicare+, we emphasize clear communication, preventive awareness, and continuity of care. Our goal is to help patients receive appropriate medical guidance and make informed decisions about their health.
TEXT,

            'optometry' => <<<'TEXT'
Our Optometry Department focuses on eye health, visual function, and the assessment of common vision-related concerns. Clear and comfortable vision is important for learning, working, driving, and performing everyday activities.

We support the evaluation of concerns such as blurred vision, eyestrain, difficulty focusing, and changes in visual clarity. Eye examinations may include assessing visual acuity, determining refractive needs, and identifying signs that require further investigation or specialist referral.

Optometric care can help individuals understand whether glasses or other vision correction options may be suitable. We also emphasize the importance of regular eye examinations, especially for people experiencing changes in vision or those with health conditions that can affect eye health.

At Medicare+, we encourage preventive eye care, timely evaluation, and appropriate referral when necessary. Our aim is to help patients make informed decisions about their vision and long-term eye wellbeing.
TEXT,

        ];

        foreach ($descriptions as $slug => $description) {
        Department::query()
        ->where('slug', $slug)
        ->update([
            'description' => $description,
        ]);

    }
}}