<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Mon Espace Parking</title>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-3xl shadow-2xl">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 border-b-4 border-blue-500 pb-2">Espace Réservation</h1>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded uppercase">Connecté : {{ Auth::user()->name }}</span>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-8 bg-blue-50 rounded-2xl text-center border-2 border-blue-200">
            <p class="text-lg text-blue-900 mb-6 font-medium">Prêt pour votre journée ? Obtenez une place en un clic.</p>
            <form action="{{ route('reservation.demande') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-full shadow-xl transform hover:scale-105 transition duration-200">
                     Attribuer une place aléatoirement
                </button>
            </form>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Ma place réservée</h3>
                <p class="text-2xl font-black text-blue-600">{{ $maPlace }}</p>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Rang file d'attente</h3>
                <p class="text-2xl font-black text-orange-500">Non inscrit</p>
            </div>
        </div>
    </div>
</body>
</html>