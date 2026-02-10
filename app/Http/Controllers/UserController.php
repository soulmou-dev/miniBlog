<?php

namespace App\Http\Controllers;

use App\Identity\Application\Command\DeleteUserCommand;
use App\Identity\Application\Command\RestoreUserCommand;
use App\Identity\Application\Command\UpdateUserCommand;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

final class UserController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    public function updateUser(Request $request){
        $userId = Auth::id();
        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $command = UpdateUserCommand::fromData($validated, $userId);

        $this->commandBus->dispatch($command);

        return redirect()->route('home')
                         ->with('success', 'Votre profile a été mis à jour avec succès');
    }

    public function deleteUser(string $id){

        $command = new DeleteUserCommand($id);

        $this->commandBus->dispatch($command);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé avec succès');
    }

    public function restoreUser(string $id){

        $command = new RestoreUserCommand($id);

        $this->commandBus->dispatch($command);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur restauré avec succès');
    }
}