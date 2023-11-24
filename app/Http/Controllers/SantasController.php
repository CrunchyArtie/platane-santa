<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $anonymousUsers = User::whereNotNull('anonyme_token')->get();

        function isShuffleValid($santas, $anonymousUsers)
        {
            foreach ($santas as $key => $santa) {
                if ($santa->id === $anonymousUsers[$key]->id) {
                    return false;
                }

            }

            return true;
        }

        do {
            $santas = $anonymousUsers->shuffle();
        } while (isShuffleValid($santas, $anonymousUsers) === false);

        foreach ($santas as $key => $santa) {
            $santa->santa_id = $anonymousUsers[$key]->id;
            $santa->save();
        }

        return redirect()->route('santas');
    }
}
