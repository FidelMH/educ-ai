<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'Mathématiques',
            'Français',
            'Histoire',
            'Géographie',
            'Physique-Chimie',
            'Sciences de la Vie et de la Terre (SVT)',
            'Anglais',
            'Espagnol',
            'Allemand',
            'Technologie',
            'Arts Plastiques',
            'Éducation Musicale',
            'Éducation Physique et Sportive (EPS)',
            'Philosophie',
            'Sciences Économiques et Sociales (SES)',
        ];

        foreach ($subjects as $subjectName) {
            $subject = Subject::create(['theme' => $subjectName]);

            Agent::create([
                'subject_id' => $subject->id,
                'prompt' => "Tu es un tuteur expert en {$subjectName}. Ton objectif est d'expliquer des concepts de manière claire, concise et pédagogique. Adapte ton langage et tes exemples au niveau de l'élève qui te sera précisé."
            ]);
        }
    }
}
