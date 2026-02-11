@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-6">Modification de l'article</h1>

    @include('blog.article._form', [
        'article' => $article,
        'action' => route('articles.update', $article->id),
        'method' => 'PATCH'
    ])
@endsection