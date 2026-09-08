<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function register(Request $request)
   {

    $validated = $request->validate([
        'name' => ["required", "string", "max:100"],
        "email" => ["required", "email", "unique:users"],
        "password" => ["required", "string", "min:6"],
    ]);

    $user = User::create([
        "name" => $validated['name'],
        "email" => $validated['email'],
        "password" => Hash::make($validated['password']),
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => 'Utilisateur créé',
        'user' => $user,
        'token' => $token,
    ], 201);


    // Token Pierra : 2|QKe1QwTEPYUPldBPm9iPktV7osc6rQaVbdKh9YPB8fb05693
    // Token Pierra login : 3|PXVc2TdPmcXaiuZUIEqtcwdTm1DnmCZaLVDHGy82791d73d0
    // Token Boby : 4|OklWspP7aq629GycIa05WM48SDDgDSDxKwX9gt4984857ef6
   }

   public function login(Request $request)
   {
        $validated = $request->validate([
            "email" => ["required", 'email'],
            "password" => ["required", 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();
        Hash::check($validated['password'], $user->password);

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => "Connexion réussie",
            "token" => $token,
        ], 200);
   }

   public function logout(Request $request)
   {
    // $request->user()->currentAccessToken()->delete();
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => "Deconnexion réussie",
    ]);
   }
}