@extends('layouts.app')

@section('title', 'Accueil')

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

<div class="max-w-6xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-bold text-gray-800 mb-10">
        Derniers articles
    </h1>

    @if($articles->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
            Aucun article publié pour le moment.
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 flex flex-col justify-between">

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $article->title }}
                        </h2>

                        <p class="text-sm text-gray-500 mb-4">
                            Par <a class="font-bold hover:underline transition"
                                href="{{ route('users.show', $article->user_id) }}">
                                {{ $article->authorName }}
                            </a>
                            • {{ $article->published_at->format('d/m/Y') }}
                        </p>

                        <p class="text-gray-600 text-sm line-clamp-3">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('articles.show', $article->id) }}"
                           class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                            Afficher
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
