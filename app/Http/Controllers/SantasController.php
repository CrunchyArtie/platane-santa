<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;

class SantasController extends Controller
{
    public function index()
    {
        $anonymousUsers = User::with(['images', 'santa', 'target'])->whereNotNull('anonyme_token')->get();
        $santas = $anonymousUsers->sortby('anonyme_token');
        return view('santas', compact('santas'));
    }

    public function shuffle()
    {
        $santas = User::with(['lastSanta', 'lastTarget'])
            ->whereNotNull('anonyme_token')
            ->orderBy('id')
            ->get();

        function isShuffleValid(Collection $targets, Collection $santas)
        {
            foreach ($targets as $key => $target) {
                /** @var \App\Models\User $target */
                /** @var \App\Models\User $santa */
                $santa = $santas[$key];

                if ($target->id === $santa->id) {
                    return false;
                }

                // Vérifier si la target n'a pas déjà eu le santa en dernier
                if ($target->lastSanta !== null && $target->lastSanta->santa->id === $santa->id) {
                    return false;
                }
            }

            return true;
        }

        do {
            $targets = $santas->shuffle();
        } while (isShuffleValid($targets, $santas) === false);

        foreach ($targets as $key => $target) {
            $target->santa_id = $santas[$key]->id;
            $target->save();
        }

        return $this->index();
    }
}
