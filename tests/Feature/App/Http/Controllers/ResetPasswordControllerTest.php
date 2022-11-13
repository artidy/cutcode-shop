<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reset_password_success(): void
    {
        $this->get(action([ResetPasswordController::class, 'page'], ['token' => 'jhaklsdjhaklsjdhaksj']))
            ->assertOk()
            ->assertSee('Сброс пароля')
            ->assertViewIs('auth.reset-password');
    }
}
