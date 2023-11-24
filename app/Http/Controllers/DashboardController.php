<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        $users = User::get();
        $parameters = Parameter::get();
        return view('dashboard', compact('users', 'parameters'));
    }

    public function update(Request $request)
    {
        if ($request->has('action')) {
            if ($request->get('action') === 'activate') {
                $user = User::find($request->get('id'));

                if ($user->anonyme_token === null) {
                    $user->anonyme_token = $this->getRandomName();
                } else {
                    $user->anonyme_token = null;
                }

                $user->save();
            } elseif ($request->get('action') === 'parameter') {
                $parameter = Parameter::find($request->get('id'));

                $parameter->value = $request->get('value');

                $parameter->save();
            } else {
                Log::error('Unknown action: ' . $request->get('action'));
            }
        }

        return redirect()->route('dashboard');

    }

    private function getRandomName()
    {
        return fake()->name();
    }
}
