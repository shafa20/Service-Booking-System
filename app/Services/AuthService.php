<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'customer',
        ]);
        $token = $user->createToken('MyApp')->plainTextToken;
        return compact('user', 'token');
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }
        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;
        return compact('user', 'token');
    }
}
