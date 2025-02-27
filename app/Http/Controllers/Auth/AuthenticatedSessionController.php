<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// use App\Models\User;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }


    public function store(LoginRequest $request): JsonResponse
{
    $request->authenticate();

    $user = Auth::user();

    // Buat token untuk user yang login
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => $user
    ]);
}


public function destroy(Request $request): JsonResponse
{
    $user = $request->user();

    if ($user) {
        // Hapus semua token user
        $user->tokens()->delete();
    }

    return response()->json(['message' => 'Logout berhasil'], 200);
}




}
