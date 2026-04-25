<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_home_route_redirects_guests_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_patient_is_redirected_to_patient_dashboard(): void
    {
        $user = User::make([
            'id' => 1,
            'name' => 'Patient Test',
            'email' => 'patient@example.com',
            'password' => 'password',
            'role' => User::ROLE_PATIENT,
        ]);

        $response = $this->be($user)->get('/dashboard');

        $response->assertRedirect(route('patient.dashboard'));
    }

    public function test_doctor_cannot_access_admin_dashboard(): void
    {
        $user = User::make([
            'id' => 2,
            'name' => 'Doctor Test',
            'email' => 'doctor@example.com',
            'password' => 'password',
            'role' => User::ROLE_DOCTOR,
        ]);

        $response = $this->be($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }
}
