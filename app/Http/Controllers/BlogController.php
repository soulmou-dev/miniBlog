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
use App\Blog\Application\Query\ShowArticleByIdHandler;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Throwable;

final class BlogController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    public function home(): View
    {
        return view('blog.home');
    }

    public function new(): View
    {
        return view('blog.article.create');
    }

    public function createArticle(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'max:10000'],
        ],
        [
            'title.required' => 'le titre est est requis',
            'title.min' => 'la taille du titre doit être minimum 3 caractères',
            'title.max' => 'la titre ne doit pas dépasser 255 caractères',
            'content.required' => 'le contenu est est requis',
            'content.max' => 'le contenu ne doit pas dépasser 10000 caractères',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['authorId'] = Auth::id();
        
        $command = CreateArticleCommand::fromData($validated);

        $this->commandBus->dispatch($command);

        return redirect()->route('home')
                         ->with('success', 'Votre article a été soumis pour validation');

    }

    public function edit(string $id): View
    {
        $article = app(GetArticleByIdHandler::class)($id);
        return view('blog.article.edit', [
            'article' => $article
        ]);
    }

    public function deleteArticle(Request $request, string $id): RedirectResponse
    {
       

        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        $data['role'] = Auth::user()->role;
        
        $command = DeleteArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        // si l'article a été supprimé depuis la page show on redirige vers le home pour éviter d'avoir error 404
        $previousRoute = $this->getPreviousRoute();
        
        return match ($previousRoute) {
            'articles.show' => redirect()->route('home')
                                         ->with('success', 'L\'article a été supprimé avec succèss'),
            default => redirect()->back()
                                 ->with('success', 'L\'article a été supprimé avec succèss'),                          
        } ;  
    }

   

   

    public function publishArticle(Request $request, string $id): RedirectResponse
    {
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        
        $command = PublishArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'article a été publié avec succèss');
    }

    public function unpublishArticle(Request $request, string $id): RedirectResponse
    {
        $data = [];
        $data['id'] = $id;
        $data['authorId'] = Auth::id();
        
        $command = UnpublishArticleCommand::fromData($data);

        $this->commandBus->dispatch($command);
        
        return redirect()->back()
                         ->with('success', 'L\'article a été désactivé avec succèss');
    }


    public function show(string $id): View
    {
        $connectedUser = null;
        if (Auth::check()) {
            $connectedUser = [
                'id' => Auth::id(),
                'role' => Auth::user()->role
            ];
        }
        $article = app(ShowArticleByIdHandler::class)($id, $connectedUser);
        
        return view('blog.article.show', [
            'article' => $article
        ]);
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