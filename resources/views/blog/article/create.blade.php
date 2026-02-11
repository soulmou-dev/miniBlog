@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-6">Créer un article</h1>

    @include('blog.article._form', [
        'article' => null,
        'action' => route('articles.create'),
        'method' => 'POST'
    ])
@endsection