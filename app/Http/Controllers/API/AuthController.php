<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    // User Registration
    
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());
        return $this->sendResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 'User registered successfully.');
    }

    // User Login
    
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->only('email', 'password'));
        if (!$result) {
            return $this->sendError('Invalid credentials.', ['error' => 'Unauthorized'], 401);
        }
        return $this->sendResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 'User login successfully.');
    }

       // Get current authenticated user
    public function me(Request $request): JsonResponse
    {
        return $this->sendResponse(new UserResource($request->user()), 'Authenticated user.');
    }

    // Logout (revoke current token)
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'Logged out successfully.');
    }

    // Refresh token (revoke old and issue new)
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $token = $user->createToken('MyApp')->plainTextToken;
        return $this->sendResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'Token refreshed successfully.');
    }
}
