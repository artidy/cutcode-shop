<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sign_up_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_it_register_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = SignUpFormRequest::factory()->create();

        $this->assertDatabaseMissing('users',
            ['email' => $request['email']]
        );

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users',
            ['email' => $request['email']]
        );

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $user = User::query()->where('email', $request['email'])->first();

        $event = new Registered($user);

        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }
}
