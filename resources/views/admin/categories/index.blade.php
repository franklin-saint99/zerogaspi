<x-app-layout> 
    <div class="container mt-4"> 
        <h2>Liste des catégories</h2> 

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3"> 
            Ajouter 
        </a> 

        <table class="table table-bordered"> 
            <tr> 
                <th>Nom</th> 
                <th>Description</th> 
                <th>Actions</th> 
            </tr> 

            @foreach($categories as $category) 
                <tr> 
                    <td>{{ $category->nom }}</td> 
                    <td>{{ $category->description }}</td> 
                    <td> 
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a> 
                    </td> 
                </tr> 
            @endforeach 
        </table> 
    </div> 
</x-app-layout>