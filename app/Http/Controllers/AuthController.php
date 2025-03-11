<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Redireciona para a página do Microsoft Entra ID
    public function redirectToProvider()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    // Callback do Microsoft Entra ID
    public function handleProviderCallback()
    {
        try {
            $socialUser = Socialite::driver('microsoft')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Falha na autenticação.');
        }

        // Procura o usuário com provider_id já cadastrado
        $user = User::where('provider_id', $socialUser->getId())->first();

        if (!$user) {
            // Caso novo usuário, cria o cadastro. 
            // Pode-se definir regras para que o primeiro usuário seja admin
            $user = User::create([
                'name'        => $socialUser->getName() ? $socialUser->getName() : $socialUser->getNickname(),
                'email'       => $socialUser->getEmail(),
                'provider'    => 'microsoft',
                'provider_id' => $socialUser->getId(),
                'role'        => 'user',
            ]);
        }

        Auth::login($user, true);

        return redirect('/')->with('success', 'Login efetuado.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}