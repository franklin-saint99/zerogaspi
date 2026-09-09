<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Modifier le produit</h1>
                <a href="{{ route('admin.produits') }}" class="text-sm text-indigo-600 hover:underline">← Retour aux produits</a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4 text-sm">
                    <ul class="mb-0 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <form method="POST" action="{{ route('admin.produits.update', $produit->id) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description', $produit->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix initial (optionnel)</label>
                            <input type="number" step="0.01" name="prix_initial" value="{{ old('prix_initial', $produit->prix_initial) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                            <input type="number" step="0.01" name="prix" value="{{ old('prix', $produit->prix) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $produit->stock) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $produit->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="disponible" {{ $produit->statut === 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="epuise" {{ $produit->statut === 'epuise' ? 'selected' : '' }}>Épuisé</option>
                            <option value="expire" {{ $produit->statut === 'expire' ? 'selected' : '' }}>Expiré</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image (laisser vide pour garder l'image actuelle)</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                        @if($produit->image)
                            <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" style="max-width:150px; margin-top:0.5rem;" class="rounded-lg">
                        @endif
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>