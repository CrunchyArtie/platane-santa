<?php

namespace App\Http\Controllers;

use App\Models\SantaRestriction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        $users = User::with(['lastSanta', 'lastTarget'])->get();
        return view('dashboard', compact('users'));
    }

    public function update(Request $request)
    {
        if ($request->has('action')) {
            if ($request->get('action') === 'activate') {
                $user = User::find($request->get('id'));

                if ($user->anonyme_token === null) {
                    $user->anonyme_token = $this->getRandomName($user->name);
                } else {
                    $user->anonyme_token = null;
                }

                $user->save();
            } elseif ($request->get('action') === 'last_target') {
                $user = User::find($request->get('id'));
                $restriction = new SantaRestriction(
                    [
                        'santa_id' => $request->last_santa_id,
                        'user_id' => $user->id
                    ]
                );
                $restriction->save();

            } else {
                Log::error('Unknown action: ' . $request->get('action'));
            }
        }

        return redirect()->route('dashboard');

    }

    private function getRandomName($str)
    {
        return $str; // fake()->name();
    }
}
