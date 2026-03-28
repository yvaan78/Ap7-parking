<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>File d'Attente - Admin</title>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-sm mb-8 border-b">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center text-sm font-medium">
            <div class="space-x-6">
                <a href="/dashboard" class="text-gray-500 hover:text-blue-600 transition"> Ma Réservation</a>
                <a href="/admin/utilisateurs" class="text-gray-500 hover:text-blue-600 transition"> Gestion Admin</a>
                <a href="/admin/attente" class="text-blue-600 border-b-2 border-blue-600 pb-1"> File d'Attente</a>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Déconnexion 🚪</button>
            </form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 italic text-blue-600 text-center">File d'attente actuelle</h1>
        
        <div class="space-y-4">
            @forelse($file as $index => $item)
                <div class="flex items-center justify-between p-4 border rounded-lg bg-blue-50">
                    <div>
                        <span class="font-bold text-lg text-blue-800">Rang #{{ $index + 1 }}</span>
                        <p class="text-gray-700 font-semibold">{{ $item->name }}</p>
                        <p class="text-xs text-gray-500 italic text-blue-600">Rang : {{ $item->rang }} | Inscrit le : {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <form action="{{ route('admin.attente.retirer', $item->id) }}" method="POST">
    @csrf
                    <button type="submit" class="bg-white border border-red-200 text-red-600 px-4 py-2 rounded hover:bg-red-50 transition text-sm font-bold">
                    Retirer
                    </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400">
                    <p class="text-5xl mb-4"></p>
                    <p>La file d'attente est vide pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>