<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = User::where("email", $request->email)->first();

        $data = [
            "token" => $user->createToken("token for user " . $user->email)->plainTextToken,
            "user" => [
                "userId" => $user->id,
                "name" => $user->name,
                "email" => $user->email
            ]
        ];

        // $request->session()->regenerate();

        return response()->json($data, 201);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        // Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // $request->user()->currentAccessToken->delete();

        // return response()->noContent();

        // Laravel return ID|TOKEN
        $plainToken = $request->bearerToken();
        $tokenParts = explode('|', $plainToken);
        $tokenValue = $tokenParts[1] ?? null;

        // Hash the actual token value for database comparison
        $hashedToken = hash('sha256', $tokenValue);

        // Attempt to find and delete the token
        $deleted = $request->user()->tokens()->where('token', $hashedToken)->deleted();

        return response()->noContent();
    }
}
