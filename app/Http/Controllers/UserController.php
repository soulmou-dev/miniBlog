<?php

namespace App\Http\Controllers;

use App\Identity\Application\Command\DeleteUserCommand;
use App\Identity\Application\Command\RestoreUserCommand;
use App\Identity\Application\Command\UpdateUserCommand;
use App\Identity\Application\Query\GetUserByIdHandler;
use App\Identity\Application\Query\ShowUserByIdHandler;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

final class UserController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    public function show(string $id): View
    {
        $connectedUser = null;
        if (Auth::check()) {
            $connectedUser = [
                'id' => Auth::id(),
                'role' => Auth::user()->role
            ];
        }

        $user = app(ShowUserByIdHandler::class)($id, $connectedUser);
        
        return view('user.show', [
            'user' => $user
        ]);
    }

    public function myProfile():View
    {
        $id = Auth::id(); 
        $user = app(GetUserByIdHandler::class)($id);
        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit(): View
    {
        $id = Auth::id(); 
        $user = app(GetUserByIdHandler::class)($id);
        return view('user.edit', [
            'user' => $user
        ]);
    }

    public function updateUser(Request $request){
        
         $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:6'],
            'password_confirmation' => ['nullable', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
        ],
        [
            'email.required' => 'l\'adresse email est requise',
            'email.email' => 'l\'adresse email n\'est pas valide',
            'password.min' => 'la taille du mot de passe doit être minimum 6 caractères',
            'first_name.required' => 'le Nom est requis',
            'last_name.required' => 'le Prénom est requis'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userId = Auth::id();
        $validated = $validator->validated();
        $command = UpdateUserCommand::fromData($validated, $userId);

        $this->commandBus->dispatch($command);

        return redirect()->route('users.profile')
                         ->with('success', 'Votre profile a été mis à jour avec succès');
    }

}