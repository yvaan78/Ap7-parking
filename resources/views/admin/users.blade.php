<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Gestion du personnel des ligues</h1>
        
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">Nom / Prénom</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Rôle actuel</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        @if($user->role != 'user' && $user->role != 'admin')
                            <form action="{{ route('admin.user.validate', $user->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approuver</button>
                            </form>
                        @endif
                        <button class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Reset Password</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>