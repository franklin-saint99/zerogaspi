<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Récapitulatif des produits</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $produits->count() }} produit(s) affiché(s)</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">← Retour au dashboard</a>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                @if($produits->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Produit</th>
                            <th class="px-6 py-3 text-left">Prix</th>
                            <th class="px-6 py-3 text-left">Date de péremption</th>
                            <th class="px-6 py-3 text-left">Magasin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $produit)
                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $produit->nom }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($produit->prix_initial && $produit->prix_initial > $produit->prix)
                                    <span style="text-decoration:line-through;color:#9ca3af;font-size:0.8rem;margin-right:0.3rem;">{{ number_format($produit->prix_initial, 2) }} €</span>
                                @endif
                                {{ number_format($produit->prix, 2) }} €
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $produit->date_peremption ? \Carbon\Carbon::parse($produit->date_peremption)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $produit->vendeur->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-16 text-gray-400">
                    <div class="text-4xl mb-2">📦</div>
                    <p>Aucun produit pour l'instant.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>