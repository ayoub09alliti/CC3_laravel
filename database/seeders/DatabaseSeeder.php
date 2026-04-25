<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Services Médicaux ───────────────────────────────────────
        $services = [
            ['name' => 'Consultation Générale',  'name_ar' => 'استشارة عامة',     'duration' => 30,  'price' => 150.00, 'icon' => 'stethoscope',    'color' => '#3B82F6'],
            ['name' => 'Cardiologie',             'name_ar' => 'أمراض القلب',      'duration' => 45,  'price' => 350.00, 'icon' => 'heart',          'color' => '#EF4444'],
            ['name' => 'Dermatologie',            'name_ar' => 'أمراض الجلد',      'duration' => 30,  'price' => 250.00, 'icon' => 'shield',         'color' => '#F59E0B'],
            ['name' => 'Pédiatrie',               'name_ar' => 'طب الأطفال',       'duration' => 30,  'price' => 200.00, 'icon' => 'baby',           'color' => '#10B981'],
            ['name' => 'Gynécologie',             'name_ar' => 'طب النساء',        'duration' => 45,  'price' => 300.00, 'icon' => 'user-nurse',     'color' => '#EC4899'],
            ['name' => 'Orthopédie',              'name_ar' => 'جراحة العظام',     'duration' => 60,  'price' => 400.00, 'icon' => 'bone',           'color' => '#8B5CF6'],
            ['name' => 'Analyse de sang',         'name_ar' => 'تحليل الدم',       'duration' => 15,  'price' => 80.00,  'icon' => 'droplet',        'color' => '#F97316'],
        ];

        foreach ($services as $service) {
            Service::create(array_merge($service, ['is_active' => true]));
        }

        // ─── Admin ───────────────────────────────────────────────────
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@medicab.ma',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0661-000-000',
        ]);

        // ─── Médecins ────────────────────────────────────────────────
        $doctors = [
            ['name' => 'Dr. Sophie Martin',   'email' => 'dr.martin@medicab.ma',   'specialty' => 'Médecine Générale'],
            ['name' => 'Dr. Karim Benali',    'email' => 'dr.benali@medicab.ma',   'specialty' => 'Cardiologie'],
            ['name' => 'Dr. Fatima Zahra',    'email' => 'dr.zahra@medicab.ma',    'specialty' => 'Gynécologie'],
            ['name' => 'Dr. Ahmed Tazi',      'email' => 'dr.tazi@medicab.ma',     'specialty' => 'Pédiatrie'],
        ];

        foreach ($doctors as $doctor) {
            User::create(array_merge($doctor, [
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '06' . rand(10000000, 99999999),
            ]));
        }

        // ─── Patients ────────────────────────────────────────────────
        $patients = [
            ['name' => 'Jean Dupont',        'email' => 'jean.dupont@email.com'],
            ['name' => 'Marie Leblanc',      'email' => 'marie.leblanc@email.com'],
            ['name' => 'Hassan Alaoui',      'email' => 'hassan.alaoui@email.com'],
            ['name' => 'Amina Chraibi',      'email' => 'amina.chraibi@email.com'],
            ['name' => 'Pierre Bernard',     'email' => 'pierre.bernard@email.com'],
            ['name' => 'patient@medicab.ma', 'email' => 'patient@medicab.ma'],
        ];

        foreach ($patients as $patient) {
            User::create(array_merge($patient, [
                'password' => Hash::make('password'),
                'role' => 'patient',
                'phone' => '06' . rand(10000000, 99999999),
            ]));
        }

        // ─── Rendez-vous de démonstration ────────────────────────────
        $patientIds = User::where('role', 'patient')->pluck('id')->toArray();
        $doctorIds  = User::where('role', 'doctor')->pluck('id')->toArray();
        $serviceIds = Service::pluck('id')->toArray();

        $statuses = ['pending', 'confirmed', 'confirmed', 'completed', 'cancelled'];
        $times = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','14:00','14:30','15:00','16:00'];
        $notesSamples = [
            'Douleurs abdominales depuis 3 jours',
            'Contrôle de routine annuel',
            'Suivi post-opératoire',
            'Renouvellement d\'ordonnance',
            'Consultation suite à des maux de tête récurrents',
            null, null, null,
        ];

        for ($i = 0; $i < 25; $i++) {
            Appointment::create([
                'patient_id'       => $patientIds[array_rand($patientIds)],
                'doctor_id'        => $doctorIds[array_rand($doctorIds)],
                'service_id'       => $serviceIds[array_rand($serviceIds)],
                'appointment_date' => now()->addDays(rand(-30, 60))->format('Y-m-d'),
                'appointment_time' => $times[array_rand($times)],
                'status'           => $statuses[array_rand($statuses)],
                'notes'            => $notesSamples[array_rand($notesSamples)],
                'email_sent'       => true,
            ]);
        }
    }
}