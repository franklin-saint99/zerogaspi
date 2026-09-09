<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Toutes les commandes</h1>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Acheteur</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                            <tr class="border-t">
                                <td class="p-4">#{{ $commande->id }}</td>
                                <td class="p-4">{{ $commande->user->name ?? 'N/A' }}</td>
                                <td class="p-4">{{ $commande->statut }}</td>
                                <td class="p-4">{{ $commande->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Aucune commande pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>