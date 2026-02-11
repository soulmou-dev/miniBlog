<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">
    <!-- Header / Navbar -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">MiniBlog</a>
                </div>
                <nav class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700">Bonjour, <b>{{ Auth::user()->lastName }} {{ Auth::user()->firstName }}</b></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                Déconnexion
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login.form') }}" class="text-blue-500 hover:text-blue-700">Connexion</a>
                        <a href="{{ route('register.form') }}" class="text-blue-500 hover:text-blue-700">Inscription</a>
                    @endguest
                </nav>
            </div>
        </div>

        @auth
            <nav class="bg-gray-800">
                <div class="max-w-7xl mx-auto px-6">
                    <ul class="flex mx-2 space-x-6 py-3 text-sm">
                        <li>
                            <a href="{{ route('users.profile') }}"
                            class="text-gray-300 hover:text-white transition">
                                Mon profil
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('articles.index') }}"
                            class="text-gray-300 hover:text-white transition">
                                Mes articles
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('articles.new') }}"
                            class="text-gray-300 hover:text-white transition">
                                Nouvel article
                            </a>
                        </li>

                        @if(auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                class="text-yellow-400 hover:text-yellow-300 transition font-semibold">
                                    Utilisateurs
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.articles.index') }}"
                                class="text-yellow-400 hover:text-yellow-300 transition font-semibold">
                                    Gestion des articles
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </nav>
        @endauth

    </header>

    <!-- Main content -->
    <main class="py-8 flex-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif -->

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-8">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} MiniBlog. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
