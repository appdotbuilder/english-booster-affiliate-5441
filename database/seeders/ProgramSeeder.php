<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            // Online Programs
            [
                'name' => 'English for Kids',
                'description' => 'Fun and interactive English learning program designed specifically for children aged 4-12 years.',
                'type' => 'online',
                'duration' => '3 months',
                'price' => 1500000,
                'features' => ['Interactive lessons', 'Games and activities', 'Progress tracking', 'Certificate'],
                'commission_rate' => 15.00,
            ],
            [
                'name' => 'Teen English Program',
                'description' => 'Comprehensive English program for teenagers with focus on speaking and communication skills.',
                'type' => 'online',
                'duration' => '4 months',
                'price' => 2000000,
                'features' => ['Speaking practice', 'Grammar mastery', 'Vocabulary building', 'Mock tests'],
                'commission_rate' => 12.00,
            ],
            [
                'name' => 'TOEFL Preparation',
                'description' => 'Intensive TOEFL preparation course with expert instructors and comprehensive materials.',
                'type' => 'online',
                'duration' => '2 months',
                'price' => 2500000,
                'features' => ['TOEFL strategies', 'Practice tests', 'Score improvement', 'Expert guidance'],
                'commission_rate' => 20.00,
            ],
            [
                'name' => 'Easy Peasy English',
                'description' => 'Beginner-friendly English program that makes learning simple and enjoyable.',
                'type' => 'online',
                'duration' => '6 months',
                'price' => 1800000,
                'features' => ['Step-by-step learning', 'Daily practice', 'Personal tutor', 'Flexible schedule'],
            ],
            [
                'name' => 'Private English Lessons',
                'description' => 'One-on-one English tutoring sessions customized to your learning needs.',
                'type' => 'online',
                'duration' => 'Flexible',
                'price' => 3000000,
                'features' => ['Personalized curriculum', '1-on-1 sessions', 'Flexible timing', 'Rapid progress'],
                'commission_rate' => 25.00,
            ],
            [
                'name' => 'General English',
                'description' => 'Complete English language program covering all four skills: speaking, listening, reading, writing.',
                'type' => 'online',
                'duration' => '5 months',
                'price' => 2200000,
                'features' => ['4 language skills', 'Interactive content', 'Regular assessments', 'Community support'],
            ],
            [
                'name' => 'Speaking Booster',
                'description' => 'Specialized program focused on improving English speaking confidence and fluency.',
                'type' => 'online',
                'duration' => '3 months',
                'price' => 1800000,
                'features' => ['Speaking drills', 'Pronunciation training', 'Conversation practice', 'Confidence building'],
                'commission_rate' => 18.00,
            ],
            [
                'name' => 'Grammar Booster',
                'description' => 'Comprehensive grammar program that covers all essential English grammar rules.',
                'type' => 'online',
                'duration' => '2 months',
                'price' => 1200000,
                'features' => ['Grammar rules', 'Practical exercises', 'Error correction', 'Writing improvement'],
            ],

            // Offline Programs (Pare)
            [
                'name' => 'Pare English Camp 2 Weeks',
                'description' => 'Intensive 2-week English immersion program in the famous English village of Pare, Kediri.',
                'type' => 'offline',
                'duration' => '2 weeks',
                'price' => 3500000,
                'features' => ['English environment', 'Accommodation', 'Meals included', 'Cultural activities'],
                'commission_rate' => 15.00,
            ],
            [
                'name' => 'Pare English Camp 1 Month',
                'description' => 'One month intensive English program in Pare with comprehensive skill development.',
                'type' => 'offline',
                'duration' => '1 month',
                'price' => 6000000,
                'features' => ['Full immersion', 'Native speakers', 'Cultural exchange', 'Certificate'],
                'commission_rate' => 18.00,
            ],
            [
                'name' => 'Pare English Camp 2 Months',
                'description' => 'Extended 2-month program for serious English learners seeking fluency.',
                'type' => 'offline',
                'duration' => '2 months',
                'price' => 10000000,
                'features' => ['Advanced training', 'Job placement support', 'Business English', 'Internship opportunities'],
                'commission_rate' => 20.00,
            ],
            [
                'name' => 'Pare English Camp 3 Months',
                'description' => 'Complete 3-month English mastery program with job placement assistance.',
                'type' => 'offline',
                'duration' => '3 months',
                'price' => 15000000,
                'features' => ['English mastery', 'Career counseling', 'Job interviews prep', 'Alumni network'],
                'commission_rate' => 22.00,
            ],
            [
                'name' => 'TOEFL Camp Pare',
                'description' => 'Specialized TOEFL preparation camp in Pare with guaranteed score improvement.',
                'type' => 'offline',
                'duration' => '1 month',
                'price' => 7500000,
                'features' => ['TOEFL focus', 'Score guarantee', 'Intensive practice', 'Expert instructors'],
                'commission_rate' => 25.00,
            ],
            [
                'name' => 'RPL English Program',
                'description' => 'Recognition of Prior Learning program for experienced English learners.',
                'type' => 'offline',
                'duration' => '2 weeks',
                'price' => 4000000,
                'features' => ['Skill assessment', 'Personalized training', 'Certification', 'Fast track'],
            ],
            [
                'name' => 'Kapal Pesiar English',
                'description' => 'Specialized English program for cruise ship job preparation.',
                'type' => 'offline',
                'duration' => '3 months',
                'price' => 12000000,
                'features' => ['Maritime English', 'Job placement', 'Interview training', 'Work visa assistance'],
                'commission_rate' => 20.00,
            ],

            // Rombongan Programs
            [
                'name' => 'English Trip',
                'description' => 'Educational English trip combining learning with tourism and cultural experiences.',
                'type' => 'rombongan',
                'duration' => '1 week',
                'price' => 5000000,
                'features' => ['Educational tour', 'English practice', 'Cultural immersion', 'Group activities'],
                'commission_rate' => 12.00,
            ],
            [
                'name' => 'Special English Day',
                'description' => 'One-day intensive English workshop for groups and organizations.',
                'type' => 'rombongan',
                'duration' => '1 day',
                'price' => 1000000,
                'features' => ['Group workshop', 'Team building', 'English games', 'Certificate'],
                'commission_rate' => 10.00,
            ],
            [
                'name' => 'Tutor Visit',
                'description' => 'Professional English tutors visit your location for group lessons.',
                'type' => 'rombongan',
                'duration' => 'Flexible',
                'price' => 2500000,
                'features' => ['On-site teaching', 'Customized curriculum', 'Group discount', 'Flexible schedule'],
                'commission_rate' => 15.00,
            ],

            // Cabang Programs
            [
                'name' => 'Cilukba (Pre-school / TK)',
                'description' => 'English learning program specially designed for pre-school children.',
                'type' => 'cabang',
                'duration' => '6 months',
                'price' => 1200000,
                'features' => ['Age-appropriate content', 'Play-based learning', 'Visual materials', 'Parent involvement'],
                'commission_rate' => 12.00,
            ],
            [
                'name' => 'Hompimpa (SD)',
                'description' => 'Fun and engaging English program for elementary school students.',
                'type' => 'cabang',
                'duration' => '8 months',
                'price' => 1500000,
                'features' => ['Elementary level', 'Interactive games', 'Homework support', 'Progress reports'],
                'commission_rate' => 12.00,
            ],
            [
                'name' => 'Hip Hip Hurray (SMP)',
                'description' => 'Dynamic English program designed for middle school students.',
                'type' => 'cabang',
                'duration' => '10 months',
                'price' => 1800000,
                'features' => ['Teen-focused', 'Academic support', 'Exam preparation', 'Social activities'],
                'commission_rate' => 15.00,
            ],
            [
                'name' => 'Insight Out (SMA)',
                'description' => 'Advanced English program for high school students preparing for university and career.',
                'type' => 'cabang',
                'duration' => '12 months',
                'price' => 2200000,
                'features' => ['Advanced level', 'University prep', 'Essay writing', 'Critical thinking'],
                'commission_rate' => 18.00,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}