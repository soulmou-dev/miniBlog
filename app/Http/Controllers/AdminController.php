<?php

namespace App\Http\Controllers;


use App\Blog\Application\Command\ApproveArticleCommand;
use App\Blog\Application\Command\CreateArticleCommand;
use App\Blog\Application\Command\DeleteArticleCommand;
use App\Blog\Application\Command\PublishArticleCommand;
use App\Blog\Application\Command\RejectArticleCommand;
use App\Blog\Application\Command\RestoreArticleCommand;
use App\Blog\Application\Command\UnpublishArticleCommand;
use App\Blog\Application\Command\UpdateArticleCommand;
use App\Blog\Application\Query\GetArticleByIdHandler;
use App\Blog\Application\Query\ShowAllArticleHandler;
use App\Blog\Application\Query\ShowArticleByIdHandler;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Throwable;

final class AdminController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}
    
    public function ArticleIndex(): View
    {
        $connectedUser = null;
        if (Auth::check()) {
            $connectedUser = [
                'id' => Auth::id(),
                'role' => Auth::user()->role
            ];
        }
        $articles = app(ShowAllArticleHandler::class)($connectedUser);
        
        return view('blog.article.index', [
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