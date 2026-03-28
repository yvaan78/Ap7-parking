<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Afficher tous les utilisateurs pour validation
    public function indexUtilisateurs() {
        $users = DB::table('users')->get();
        return view('admin.users', compact('users'));
    }

    // Valider un compte (Critère : Validations inscriptions)
    public function validerUtilisateur($id) {
        // On passe le rôle de 'guest' à 'user' pour autoriser l'accès
        DB::table('users')->where('id', $id)->update(['role' => 'user']);
        return back()->with('success', 'Utilisateur validé avec succès !');
    }

    // Réinitialiser un mot de passe (Critère : Gestion des mots de passe)
    public function resetPassword($id) {
        $nouveauMdp = Hash::make('azerty123'); // Mot de passe par défaut
        DB::table('users')->where('id', $id)->update(['password' => $nouveauMdp]);
        return back()->with('success', 'Mot de passe réinitialisé à : azerty123');
    }

    // Ajouter une place (Critère : Places ajouter/modifier/supprimer)
    public function ajouterPlace(Request $request) {
        DB::table('places')->insert([
            'numero_place' => $request->numero,
            'statut' => 'libre',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return back()->with('success', 'La place a été ajoutée au parking.');
    }

    // Consulter et éditer la file d'attente
   public function indexAttente()
{
    $file = DB::table('waiting_list')
        ->join('users', 'waiting_list.user_id', '=', 'users.id')
        ->select('waiting_list.*', 'users.name') 
        ->orderBy('waiting_list.created_at', 'asc') // Tri par date de création
        ->get();

    return view('admin.attente', compact('file'));
}
public function retirerAttente($id)
{
    DB::table('waiting_list')->where('id', $id)->delete();
    return back()->with('success', "L'utilisateur a été retiré de la file d'attente.");
}
}