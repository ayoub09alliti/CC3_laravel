<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;
/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()->id,
            'doctor_id' => User::where('role', 'medecin')->inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
