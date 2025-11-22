<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\CourseClass;
use App\Models\ParticipantClass;
use Illuminate\Database\Seeder;

class ParticipantClassSeeder extends Seeder
{
    public function run(): void
    {
        $participants = Participant::all();
        $classes      = CourseClass::all();

        if ($participants->isEmpty() || $classes->isEmpty()) {
            return;
        }

        foreach ($participants as $participant) {
            // setiap peserta ikut 1–3 kelas random
            $randomClasses = $classes->random(rand(1, min(3, $classes->count())));

            foreach ($randomClasses as $class) {
                ParticipantClass::updateOrCreate(
                    [
                        'participant_id' => $participant->participant_id,
                        'courseclass_id' => $class->courseclass_id,
                    ],
                    [
                        'enrolled_at' => now()->subDays(rand(0, 30)),
                        'status'      => 'active',
                        'grade'       => null,
                        'progress'    => rand(0, 100),
                    ]
                );
            }
        }
    }
}

