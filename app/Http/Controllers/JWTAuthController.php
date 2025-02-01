<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $token = null;

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = Auth::user();

            // (optional) Attach the role to the token.
            // $token = JWTAuth::claims([
            //     'role' => $user->role,
            //     'name' => $user->name,
            // ])->fromUser($user);
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'message' => null,
                'data' => [],
                'errors' => null,
                'token' => $token,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'data' => [],
                'token' => $token,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        /* get claims from payload */
        // $payload = JWTAuth::parseToken()->getPayload();
        // dd($payload->get('name'));

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * refresh token
     */
    public function refreshToken()
    {
        // return JWTAuth::refresh(JWTAuth::getToken());
        $token = JWTAuth::refresh(true, true);
        return response()->json([
            'success' => true,
            'message' => null,
            'data' => [],
            'errors' => null,
            'token' => $token,
        ]);
    }
}
