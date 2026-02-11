@extends('layouts.app')

@section('title', '500 - Erreur serveur')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-6 py-16 bg-gray-100">

    <div class="max-w-xl w-full bg-white shadow-lg rounded-2xl p-10 text-center">

        <h1 class="text-6xl font-bold text-red-600 mb-4">
            500
        </h1>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Une erreur est survenue
        </h2>

        <p class="text-gray-600 mb-8">
            Une erreur interne du serveur s’est produite.  
            Merci de réessayer plus tard.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('home') }}"
               class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition">
                Accueil
            </a>

            <button onclick="window.location.reload()"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Réessayer
            </button>
        </div>

    </div>

</div>
@endsection