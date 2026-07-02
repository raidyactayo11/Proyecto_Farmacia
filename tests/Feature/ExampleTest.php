<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_dashboard_redirige_a_login_sin_sesion()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_carga_para_administrador()
    {
        $rol = Role::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Acceso completo al sistema',
        ]);

        $usuario = User::create([
            'name' => 'Administrador',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => $rol->id,
        ]);

        $response = $this->actingAs($usuario)->get('/');

        $response->assertStatus(200);
    }
}
