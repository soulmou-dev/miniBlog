@extends('layouts.app')

@section('content')
 <!-- Messages flash -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Erreurs de validation -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
<div class="min-h-screen bg-gray-100 py-10 px-6">

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">

        {{-- Titre de l'article --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            {{ $article->title }}
        </h1>

        {{-- Informations --}}
        <div class="flex items-center text-gray-500 text-sm mb-6 space-x-4">
            <span><span class="font-bold">Auteur : </span>{{ $article->authorName ?? 'Inconnu' }}</span>
            @if($article->published_at)
                <span><span class="font-bold">Publié le : </span>{{ $article->published_at->format('d/m/Y H:i') }}</span>
            @endif
            @if(auth()->check())
                <span class="font-bold">Statut : 
                    @if($article->status === 'pending_validation')
                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs">En cours de validation</span>
                    @elseif($article->status === 'approved')
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">Approuvé</span>
                    @elseif($article->status === 'rejected')
                        <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs">Rejecté</span>
                    @elseif($article->status === 'deleted')
                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs">Supprimé</span>
                    @elseif($article->status === 'published')
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">Publié</span>
                    @else
                        <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs">Non publié</span>    
                    @endif
                </span>
            @endif
        </div>

        {{-- Contenu --}}
        <div class="prose prose-lg text-gray-700">
            {!! nl2br(e($article->content)) !!}
        </div>

        {{-- Boutons admin/auteur pour éditer/supprimer --}}
        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $article->user_id))
            <div class="mt-6 flex space-x-3">
                @if(auth()->user()->isAdmin() && $article->status === 'pending_validation' && auth()->id() !== $article->user_id )
                    <form method="POST" action="{{ route('admin.articles.approve', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Approuver
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.articles.reject', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            Rejeter
                        </button>
                    </form>
                @endif
                @if(auth()->id() === $article->user_id)
                    <a href="{{ route('articles.edit', $article->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Éditer
                    </a>
                    @if($article->status === 'approved')
                        <form method="POST" action="{{ route('articles.publish', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Publier
                        </button>
                    </form>
                    @elseif($article->status === 'published')
                        <form method="POST" action="{{ route('articles.unpublish', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            Désactiver
                        </button>
                    </form>
                    @endif

                @endif    

                @if($article->status !== 'deleted')
                    <form method="POST" action="{{ route('articles.delete', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Supprimer
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.articles.restore', $article->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Restaurer
                        </button>
                    </form>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
