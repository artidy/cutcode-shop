<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserAction extends TestCase
{
    use RefreshDatabase;

    public function test_it_user_crested_success(): void
    {
        $email = 'testing@devandy.me';

        $action = app(RegisterNewUserContract::class);

        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);

        $action(NewUserDTO::make('Test', $email, '123456789'));

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }
}
