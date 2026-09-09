<x-app-layout> 
<div class="container mt-4"> 
<h2>Mes Produits</h2> 
<a href="{{ route('seller.products.create') }}" 
class="btn btn-primary mb-3"> 
Ajouter un produit 
</a> 
<table class="table table-bordered"> 
<thead> 
<tr> 
<th>ID</th> 
<th>Nom</th> 
<th>Prix</th> 
<th>Stock</th> 
<th>Actions</th> 
</tr> 
</thead> 
<tbody> 
@forelse($products as $product) 
 
                <tr> 
                    <td>{{ $product->id }}</td> 
 
                    <td>{{ $product->nom }}</td> 
 
                    <td>{{ $product->prix }} €</td> 
 
                    <td>{{ $product->stock }}</td> 
 
                    <td> 
 
                        <a href="{{ route('seller.products.edit', $product) 
}}" 
                           class="btn btn-warning btn-sm"> 
                            Modifier 
                        </a> 
 
                        <form method="POST" 
                              action="{{ route('seller.products.destroy', 
$product) }}" 
                              style="display:inline"> 
 
                            @csrf 
                            @method('DELETE') 
 
                            <button class="btn btn-danger btn-sm"> 
                                Supprimer 
                            </button> 
 
                        </form> 
 
                    </td> 
                </tr> 
 
            @empty 
 
                <tr> 
                    <td colspan="5"> 
                        Aucun produit trouvé 
                    </td> 
                </tr> 
 
            @endforelse 
 
            </tbody> 
 
        </table> 
 
    </div> 
 
</x-app-layout> 