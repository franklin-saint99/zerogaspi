<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des utilisateurs</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ $acheteurs->count() }} acheteur(s) inscrit(s)</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">← Retour au dashboard</a>
            </div>

            {{-- Onglets --}}
            <div class="flex gap-2 mb-6">
                <a href="{{ route('admin.vendeurs') }}" class="bg-white text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 border border-gray-200">Vendeurs</a>
                <span class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Acheteurs</span>
            </div>

            @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4 text-sm">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4 text-sm">
                ⚠️ {{ session('error') }}
            </div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                @if($acheteurs->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Inscrit le</th>
                            <th class="px-6 py-3 text-left">Statut</th>
                            <th class="px-6 py-3 text-left"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acheteurs as $acheteur)
                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $acheteur->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $acheteur->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $acheteur->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                @if($acheteur->actif)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">✅ Actif</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">🚫 Désactivé</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.utilisateurs.toggle', $acheteur->id) }}">
                                    @csrf @method('PUT')
                                    @if($acheteur->actif)
                                        <button type="submit" onclick="return confirm('Désactiver ce compte ?')"
                                            class="bg-red-100 text-red-800 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-200">
                                            Désactiver
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-green-700">
                                            Réactiver
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-16 text-gray-400">
                    <div class="text-4xl mb-2">🛍️</div>
                    <p>Aucun acheteur inscrit pour l'instant.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>