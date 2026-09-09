<x-app-layout> 
    <div class="container mt-4"> 
        <h2>Modifier une catégorie</h2> 

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.update', $category) }}"> 
            @csrf 
            @method('PUT') 

            <div class="mb-3"> 
                <label>Nom</label> 
                <input type="text" name="nom" value="{{ old('nom', $category->nom) }}" class="form-control"> 
            </div> 

            <div class="mb-3"> 
                <label>Description</label> 
                <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea> 
            </div> 

            <button class="btn btn-success">Modifier</button> 
        </form> 
    </div> 
</x-app-layout>