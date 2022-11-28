<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function callback(string $driver)
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::updateOrCreate([
            $driver . '_id' => $githubUser->getId(),
        ], [
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'password' => bcrypt(str()->random()),
        ]);

        SessionRegenerator::run(fn () => auth()->login($user));

        return redirect()->intended(route('home'));
    }
}
