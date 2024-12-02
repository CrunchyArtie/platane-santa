<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function get(Request $request)
    {
        $request->authenticate();
        $user = $request->user();
        $token = $user->createToken(env('APP_NAME'))->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Invalid credentials'], 422);
            }

            return redirect('/login')->withErrors(['email' => 'Invalid credentials']);
        }

        $user = $request->user()->load(['images', 'target.images', 'questions']);
        $token = $user->createToken(env('APP_NAME'))->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
