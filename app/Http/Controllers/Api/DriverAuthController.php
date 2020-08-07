<?php

namespace App\Http\Controllers\Api;


use Hash;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Driver\DriverSignUpRequest;
use App\Http\Requests\Api\Driver\DriverLoginRequest;

class DriverAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:driver', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(DriverLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated Driver
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the Driver out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return \Auth::guard('driver');
    }

    public function signup(DriverSignUpRequest $request)
    {
        $driver = Driver::create([
            "name" => $request->name,
            "email" => $request->email,
            "username"  => $request->username,
            "phone_number" => $request->phone_number,
            "password" => Hash::make($request->password)
        ]);

        if($driver) {
            return response()->json([
                'message' => 'Sign Up Successfully.',
                'driver' => $driver
            ], 201);
        } else {
            return response()->json([
                "message" => "Driver Creation Failed."
            ], 500);
        }
    }

    public function payload()
    {
        return $this->guard()->payload();
    }
}
