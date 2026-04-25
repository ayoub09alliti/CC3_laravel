<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'patient',
            'phone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    public function doctor(): static
    {
        $specialties = [
            'Médecine Générale', 'Cardiologie', 'Dermatologie',
            'Pédiatrie', 'Gynécologie', 'Orthopédie', 'Neurologie'
        ];
        return $this->state(fn (array $attributes) => [
            'role' => 'doctor',
            'specialty' => fake()->randomElement($specialties),
        ]);
    }

    public function patient(): static
    {
        return $this->state(fn (array $attributes) => ['role' => 'patient']);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => ['role' => 'admin']);
    }
}