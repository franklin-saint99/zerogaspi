<x-app-layout>

<div class="container mt-4">

    <h2>Modifier le produit</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('seller.products.update', $product->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text"
                   name="nom"
                   value="{{ old('nom', $product->nom) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description"
                      class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Prix initial (avant réduction, optionnel)</label>
                <input type="number"
                       step="0.01"
                       name="prix_initial"
                       value="{{ old('prix_initial', $product->prix_initial) }}"
                       class="form-control"
                       placeholder="Ex : 5.00">
            </div>

            <div class="col-md-6 mb-3">
                <label>Prix</label>
                <input type="number"
                       step="0.01"
                       name="prix"
                       value="{{ old('prix', $product->prix) }}"
                       class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number"
                   name="stock"
                   value="{{ old('stock', $product->stock) }}"
                   class="form-control">
        </div>

        <div class="mb-3">

            <label>Catégorie</label>

            <select name="category_id"
                    class="form-select">

                @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->nom }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">
            <label>Date de péremption *</label>
            <input type="date"
                   name="date_peremption"
                   value="{{ old('date_peremption', $product->date_peremption ? \Carbon\Carbon::parse($product->date_peremption)->format('Y-m-d') : '') }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Image (laisser vide pour garder l'image actuelle)</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->nom }}" style="max-width:150px; margin-top:0.5rem;">
            @endif
        </div>

        <button class="btn btn-success">
            Enregistrer les modifications
        </button>

    </form>
</div>
</x-app-layout>