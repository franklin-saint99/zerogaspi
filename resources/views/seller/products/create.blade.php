<x-app-layout>

<div class="container mt-4">

    <h2>Ajouter un produit</h2>

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
          action="{{ route('seller.products.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text"
                   name="nom"
                   value="{{ old('nom') }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description"
                      class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Photo du produit</label>
            <input type="file"
                   name="image"
                   accept="image/*"
                   class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Prix initial (avant réduction, optionnel)</label>
                <input type="number"
                       step="0.01"
                       name="prix_initial"
                       value="{{ old('prix_initial') }}"
                       class="form-control"
                       placeholder="Ex : 5.00">
            </div>

            <div class="col-md-6 mb-3">
                <label>Prix de vente</label>
                <input type="number"
                       step="0.01"
                       name="prix"
                       value="{{ old('prix') }}"
                       class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number"
                   name="stock"
                   value="{{ old('stock') }}"
                   class="form-control">
        </div>

        <div class="mb-3">

            <label>Catégorie</label>

            <select name="category_id"
                    class="form-select">

                @foreach($categories as $category)

                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nom }}
                    </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-success">
            Enregistrer
        </button>
</form>
</div>
</x-app-layout>