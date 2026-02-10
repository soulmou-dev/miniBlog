<?php

namespace App\Http\Controllers;

use App\Identity\Application\Command\CreateUserCommand;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

final class AuthController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ],
        [
            'email.required' => 'l\'adresse email est requise',
            'email.email' => 'l\'adresse email n\'est pas valide',
            'password.required' => 'le mot de passe est requis'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if(Auth::attempt($credentials,$remember)){
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // Connexion échouée
        return back()->withInput($request->only('email'))
                     ->withErrors(['login' => 'Email ou mot de passe incorrect.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'min:6'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
        ],
        [
            'email.required' => 'l\'adresse email est requise',
            'email.email' => 'l\'adresse email n\'est pas valide',
            'password.required' => 'le mot de passe est requis',
            'password.min' => 'la taille du mot de passe doit être minimum 6 caractères',
            'password_confirmation.required' => 'la confirmation du mot de passe est obligatoire',
            'password_confirmation.min' => 'la taille du mot de passe confirmé doit être minimum 6 caractères',
            'first_name.required' => 'le Nom est requis',
            'last_name.required' => 'le Prénom est requis'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $command = CreateUserCommand::fromData($validated);

        $this->commandBus->dispatch($command);

        return redirect()->route('home')
                         ->with('success', 'Votre compte a été créé avec succès');
    }
}

