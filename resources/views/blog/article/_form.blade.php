<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    {{-- Title --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Titre</label>
        <input
            type="text"
            name="title"
            value="{{ old('title', $article?->title) }}"
            class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
        >
    </div>

    {{-- Content --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Contenu</label>
        <textarea
            name="content"
            rows="6"
            class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
        >{{ old('content', $article?->content) }}</textarea>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end">
        <button
            type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
            Enregistrer
        </button>
    </div>
</form>
