<?php

namespace App\Http\Controllers;


use App\Blog\Application\Command\ApproveArticleCommand;
use App\Blog\Application\Command\RejectArticleCommand;
use App\Blog\Application\Command\RestoreArticleCommand;
use App\Blog\Application\Query\ShowAllArticlesHandler;
use App\Identity\Application\Command\DeleteUserCommand;
use App\Identity\Application\Command\RestoreUserCommand;
use App\Identity\Application\Query\ShowAllUsersHandler;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

final class AdminController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}
    
    public function UserIndex(): View
    {
        $users = app(ShowAllUsersHandler::class)();
        
        return view('admin.user.index', [
            'users' => $users
        ]);
    }

    public function deleteUser(Request $request, string $id): RedirectResponse
    {  
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = DeleteUserCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'utilisateur a été supprimé avec succèss');
    }

    public function restoreUser(Request $request, string $id): RedirectResponse
    {  
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = RestoreUserCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'utilisateur a été restauré avec succèss');
    }

    public function ArticleIndex(): View
    {
        $connectedUser = null;
        if (Auth::check()) {
            $connectedUser = [
                'id' => Auth::id(),
                'role' => Auth::user()->role
            ];
        }
        $articles = app(ShowAllArticlesHandler::class)($connectedUser);
        
        return view('admin.article.index', [
            'articles' => $articles
        ]);
    }

    public function restoreArticle(Request $request, string $id): RedirectResponse
    {  
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = RestoreArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'article a été restauré avec succèss');
    }

    public function approveArticle(Request $request, string $id): RedirectResponse
    {  
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = ApproveArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'article a été approuvé avec succèss');
    }

    public function rejectArticle(Request $request, string $id): RedirectResponse
    {  
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = RejectArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'article a été rejecté avec succèss');
    }

    private function getPreviousRoute():?string
    {
        try {
            $previousRoute = app('router')
            ->getRoutes()
            ->match(Request::create((url()->previous())))
            ->getName();
            return $previousRoute;
        } catch (Throwable $e){
            return null;
        }
    }
}    