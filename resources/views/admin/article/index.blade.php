@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6">

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Gestion des Articles
        </h1>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Auteur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                @forelse($articles as $article)

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $article->title }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $article->authorName }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($article->status === 'pending_validation')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    En cours de validation
                                </span>
                            @elseif($article->status === 'approved')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Approuvé
                                </span>
                            @elseif($article->status === 'published')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Publié
                                </span>
                            @elseif($article->status === 'rejected')
                                <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">
                                    Rejeté
                                </span>
                            @elseif($article->status === 'deleted')
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                    Supprimé
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('articles.show', $article->id) }}"
                                class="px-2 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Afficher
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Aucun article trouvé.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
