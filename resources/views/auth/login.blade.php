@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>

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

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:ring-blue-300"
                   required autofocus>
        </div>

        <!-- Password -->
        <div>
            <label class="block text-gray-700">Mot de passe</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:ring-blue-300"
                   required>
        </div>

        <!-- Remember me -->
        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Se souvenir de moi</label>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Connexion
            </button>
        </div>

        <!-- Lien vers register -->
        <div class="text-center text-gray-600 mt-4">
            Vous n'êtes pas encore inscrit ? <a href="{{ route('register.form') }}" class="text-blue-500 hover:text-blue-700">S’inscrire</a>
        </div>
    </form>
</div>
@endsection
