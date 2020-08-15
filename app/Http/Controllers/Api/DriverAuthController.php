<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Driver\ChangePasswordRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Driver\DriverSignUpRequest;
use App\Http\Requests\Api\Driver\DriverLoginRequest;
use App\Http\Requests\Api\Driver\ForgotPasswordRequest;
use App\Http\Requests\Api\Driver\UpdateDriverProfileRequest;
use App\Http\Requests\Api\Driver\VerifyForgotPasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Repositories\Driver\DriverRepositoryInterface;
use App\Services\Driver\ForgotPasswordService;
use Illuminate\Support\Facades\Hash as Hash;

class DriverAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // Private Fields
    protected $forgotPasswordService, $userRepository;

    public function __construct(ForgotPasswordService $forgotPasswordService, DriverRepositoryInterface $driverRepository)
    {
        $this->middleware('auth:driver',
                                    [
                                        'except' =>
                                            [
                                                'login',
                                                'signup',
                                                'sendForgotPasswordOtp',
                                                'verifyForgotPasswordOtp',
                                                'resetPassword'
                                                ]
                            ]);
        $this->userRepository = $driverRepository;
        $this->forgotPasswordService = $forgotPasswordService;
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

     // Update Password
     public function updatePassword(ChangePasswordRequest $request)
     {
         $user = $request->user();
         $check_hash = Hash::check($request->old_password, $user->password);
         if ($check_hash) {
             $change_password = $this->userRepository->changePassword($user, $request->all());
             if($change_password) {
                 return response()->json([
                     'message' => 'Password Changed Successfully',
                 ], 200);
             }

         } else {
             return response()->json([
                 'message' => 'You\'ve entered incorrect password'
             ], 403);
         }
     }

    public function sendForgotPasswordOtp(ForgotPasswordRequest $request)
    {
        $result = $this->forgotPasswordService->forgetPassword($request->all());
        if($result) {
            return response()->json([
                'message' => 'Email sent successfully. Check your e-mail.'
            ], 200);
        } else {
            return response()->json([
                'error' => 'something went wrong'
            ], 400);
        }
    }

   public function verifyForgotPasswordOtp(VerifyForgotPasswordRequest $request)
   {
       $result = $this->forgotPasswordService->verifyOtp($request->email, $request->otp);
       if($result) {
            return response()->json([
                'message' => 'OTP updated successfully.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Your OTP is expired or this OTP don\'t exist'
            ], 400);
        }
   }

   public function resetPassword(ResetPasswordRequest $request)
   {
        $result = $this->forgotPasswordService->resetPassword($request->email, $request->otp, $request->new_password);

        if($result) {
            return response()->json([
                'message' => 'Password updated successfully.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something Went Wrong. Try Again Later.'
            ], 400);
        }
   }

   public function updateProfile(UpdateDriverProfileRequest $request)
   {
        unset($request->password);
        $user = $this->userRepository->getUserByEmail($request->user()->email);
        $update = $this->userRepository->update($user, $request->all());
        if($update) {
            return response()->json([
                'message' => 'User profile updated successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong. Try again later'
            ], 400);
        }

   }
}
