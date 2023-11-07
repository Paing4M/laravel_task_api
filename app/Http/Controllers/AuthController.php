<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  public function login(Request $request) {
    $validated = $request->validate([
      'email' => 'required',
      'password' => 'required',
    ]);

    if (!Auth::attempt($validated)) {
      return response()->json(['message' => 'Login Information Invalid.'], 401);
    }

    $user = User::where('email', $validated['email'])->first();
    return response()->json([
      'access_token' => $user->createToken('api_token')->plainTextToken,
      'token_type' => 'Bearer',
    ]);
  }

  public function register(Request $request) {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users,email',
      'password' => 'required|confirmed'
    ]);


    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->save();

    return response()->json([
      'data' => $user,
      'access_token' => $user->createToken('api_token')->plainTextToken,
      'token_type' => 'Bearer',
    ], 201);
  }
}
