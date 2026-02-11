@extends('layouts.app')

@section('title', '404 - Page introuvable')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-6 py-16 bg-gray-100">

    <div class="max-w-xl w-full bg-white shadow-lg rounded-2xl p-10 text-center">

        <h1 class="text-6xl font-bold text-blue-600 mb-4">
            404
        </h1>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Page introuvable
        </h2>

        <p class="text-gray-600 mb-8">
            La page que vous recherchez n'existe pas ou a été déplacée.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('home') }}"
               class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition">
                Retour à l’accueil
            </a>

            <button onclick="window.history.back()"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Page précédente
            </button>
        </div>

    </div>

</div>
@endsection