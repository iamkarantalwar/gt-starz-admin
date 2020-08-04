<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Services\User\ForgotPasswordService;
use App\Http\Requests\Api\User\UserLoginRequest;
use App\Http\Requests\Api\User\UserSignUpRequest;
use App\Http\Requests\Api\User\ChangePasswordRequest;
use App\Http\Requests\Api\User\ForgotPasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Http\Requests\Api\User\VerifyForgotPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class UserAuthController extends Controller
{
    use ResetsPasswords;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

     protected $userRepository, $forgotPasswordService;

    public function __construct(UserRepository $userRepository, ForgotPasswordService $forgotPasswordService)
    {
        $this->middleware('auth:user', ['except' => ['login', 'signup', 'sendForgotPasswordOtp', 'verifyForgotPasswordOtp', 'resetPassword']]);
        $this->userRepository = $userRepository;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            $user = $this->guard()->user();
            //Check If User Is Approved Or Not
            if($user->approved) {
                return $this->respondWithToken($token);
            } else {
                return response()->json(['error' => 'Forbidden', 'message' => 'User is not approved yet.'], 403);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
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
        return \Auth::guard('user');
    }

    public function signup(UserSignUpRequest $request)
    {
        $user = $this->userRepository->create($request->all());

        if($user) {
            return response()->json([
                'message' => 'Sign Up Successfully.',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                "message" => "User Creation Failed."
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
}
