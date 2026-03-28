<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function demander(Request $request)
    {
        $user = Auth::user();

        // 1. Chercher une place libre
        $placeLibre = DB::table('places')
            ->where('est_disponible', 1)
            ->inRandomOrder()
            ->first();

        if ($placeLibre) {
            // 2. Créer la réservation
            DB::table('reservations')->insert([
                'user_id'    => $user->id,
                'place_id'   => $placeLibre->id,
                'date_debut' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Marquer la place comme occupée
            DB::table('places')
                ->where('id', $placeLibre->id)
                ->update(['est_disponible' => 0]);

            return back()->with('success', "Félicitations ! La place n°{$placeLibre->numero} vous a été attribuée.");
        } else {
            // 4. File d'attente

            // Vérifier si l'utilisateur est déjà dans la file
            $dejaDansFile = DB::table('waiting_list')
                ->where('user_id', $user->id)
                ->exists();

            if ($dejaDansFile) {
                return back()->with('error', "Vous êtes déjà dans la file d'attente.");
            }

            // Trouver le dernier rang
            $dernierRang = DB::table('waiting_list')->max('rang') ?? 0;

            // Ajouter à la file
            DB::table('waiting_list')->insert([
                'user_id' => $user->id,
                'rang' => $dernierRang + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('error', "Plus de place ! Vous êtes en file d'attente au rang #" . ($dernierRang + 1));
        }
    }
}