@extends('layouts.app')

@section('title', 'Profil utilisateur')

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

<div class="max-w-4xl mx-auto px-6 py-12">

    <div class="bg-white rounded-2xl shadow p-8">

        {{-- Header profil --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $user->firstName }} {{ $user->lastName }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Membre depuis <span class="font-bold text-gray-800">{{ $user->created_at->format('d/m/Y') }}</span>
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Articles: <span class="font-bold text-gray-800">{{ $user->articles_count }}</span>
                </p>
            </div>

            {{-- Badge rôle --}}
            <span class="px-3 py-1 text-xs rounded-full
                @if($user->isAdmin())
                    bg-yellow-100 text-yellow-800
                @else
                    bg-blue-100 text-blue-800
                @endif
            ">
                {{ $user->role }}
            </span>
        </div>

        {{-- Informations principales --}}
        <div class="space-y-4">

            {{-- Email visible uniquement si admin ou propriétaire --}}
            @auth
                @if(auth()->id() === $user->id || auth()->user()->isAdmin())
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-800 font-medium">
                            {{ $user->email }}
                        </p>
                    </div>
                @endif
            @endauth

        </div>

        {{-- Actions --}}
        @auth
            @if(auth()->id() === $user->id)
                <div class="mt-8">
                    <a href="{{ route('users.profile.edit') }}"
                       class="inline-block px-5 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                        Modifier mon profil
                    </a>
                </div>
            @endif

            @if(auth()->user()->isAdmin() && auth()->id() !== $user->id)
                <div class="mt-8">
                    @if($user->isDeleted())
                        <form method="POST" action="{{ route('admin.users.restore', $user->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="px-5 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                Restaurer
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @endauth

    </div>

</div>
@endsection
