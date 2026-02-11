@extends('layouts.app')

@section('title', 'Modifier le profil')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-8">
            Modifier mon profil
        </h1>

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

        <form method="POST" action="{{ route('users.profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- First Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Prénom
                </label>
                <input type="text"
                       name="first_name"
                       value="{{ old('first_name', $user->firstName) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
                @error('firstName')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom
                </label>
                <input type="text"
                       name="last_name"
                       value="{{ old('last_name', $user->lastName) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
                @error('lastName')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password (optionnel) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nouveau mot de passe (optionnel)
                </label>
                <input type="password"
                       name="password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmer le mot de passe
                </label>
                <input type="password"
                       name="password_confirmation"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Buttons --}}
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('users.profile') }}"
                   class="text-gray-600 hover:text-gray-800 text-sm">
                    Annuler
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Mettre à jour
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
