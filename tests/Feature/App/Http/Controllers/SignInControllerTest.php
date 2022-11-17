<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Requests\SignInFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_login_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_it_sign_in_success(): void
    {
        $email = 'testing@devandy.me';
        $password = '123456789';

        $user = UserFactory::new()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $email,
            'password' => $password
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_it_logout_success(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user)->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

    public function test_it_logout_guest_middleware_fail(): void
    {
        $this->delete(action([SignInController::class, 'logout']))
            ->assertRedirect(route('home'));
    }
}
