<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Account;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/accounts/token', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required']
    ]);
    
    $account = Account::where('name', $validated['name'])->firstOrFail();
    return response()->json([
        'token' => $account->createToken('account-token')->accessToken
    ]);
});

Route::post('/register', function (Request $request) {

    $validated = $request->validate([
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:6'],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    $token = $user->createToken('api-token')->accessToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});

Route::post('/login', function (Request $request) {

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $user = User::where('email', $request->email)->first();

    $token = $user->createToken('api-token')->accessToken;

    return [
        'token' => $token
    ];
});
