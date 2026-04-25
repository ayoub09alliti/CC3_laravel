<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'confirmed', 'confirmed', 'completed', 'cancelled'];

        return [
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()?->id ?? 1,
            'doctor_id'  => User::where('role', 'doctor')->inRandomOrder()->first()?->id ?? 2,
            'service_id' => Service::inRandomOrder()->first()?->id ?? 1,
            'appointment_date' => fake()->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d'),
            'appointment_time' => fake()->randomElement([
                '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
                '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00'
            ]),
            'status' => fake()->randomElement($statuses),
            'notes' => fake()->optional(0.5)->sentence(),
            'email_sent' => true,
        ];
    }
}