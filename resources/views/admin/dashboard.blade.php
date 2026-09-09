<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Administrateur</h1>

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Utilisateurs</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Produits</p>
                    <p class="text-3xl font-bold text-green-600">{{ \App\Models\Product::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Commandes</p>
                    <p class="text-3xl font-bold text-amber-600">{{ \App\Models\Commande::count() }}</p>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Gestion des vendeurs</h2>
                    <p class="text-gray-500 text-sm mb-4">Voir, activer ou désactiver les comptes vendeurs.</p>
                    <a href="{{ route('admin.vendeurs') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                        Gérer les vendeurs
                    </a>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Récapitulatif des produits</h2>
                    <p class="text-gray-500 text-sm mb-4">Consulter tous les produits publiés sur la plateforme.</p>
                    <a href="{{ route('admin.produits') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                        Voir les produits
                    </a>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Gestion des commandes</h2>
                    <p class="text-gray-500 text-sm mb-4">Suivre toutes les commandes en cours.</p>
                    <a href="{{ route('admin.commandes') }}" class="inline-block bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 text-sm">
                        Voir les commandes
                    </a>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Gestion des catégories</h2>
                    <p class="text-gray-500 text-sm mb-4">Ajouter et modifier les catégories.</p>
                    <a href="{{ route('categories.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm">
                        Gérer les catégories
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>