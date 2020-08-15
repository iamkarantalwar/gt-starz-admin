<?php

namespace App\Services\Driver;

use Carbon\Carbon;
use App\Models\ForgetPasswordOtp;
use App\Repositories\User\UserRepositoryInterface;
use App\Mail\ForgetPasswordEmail;
use App\Repositories\Driver\DriverRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordService
{
    // Inject User Repository
    protected $userReposiotry, $forgetPasswordRepository;

    public function __construct(DriverRepositoryInterface $userRepository, ForgetPasswordOtp $forgetPasswordOtp)
    {
        $this->userReposiotry = $userRepository;
        $this->forgetPasswordOtp = $forgetPasswordOtp;
    }

    public function forgetPassword(array $data)
    {
        //Generate the otp
        $otp = $this->generateOtp();
        //Get the User From Email
        $user = $this->userReposiotry->getDriverByEmail($data['email']);
        //Check count of existing OTPs with user
        if($this->existingSentOtpCount($user)) {
            //Delete the existing OTPs
            $this->deleteExistingOtps($user->email);
        }
        //Create the otp of the user
        $otp = $this->createOtp($user, $otp);
        // If OTP is successfully update
        if($otp) {
            //Send email to the user
            $mail = $this->sendEmail($otp->otp, $user);
            if($mail) {
                return $mail;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function existingSentOtpCount($user)
    {
        return $this->forgetPasswordOtp
             ->where('email', $user->email)
             ->where('otp_user_type', 'App\Models\Driver')
             ->count();
    }

    public function deleteExistingOtps($email)
    {
        $otps = $this->forgetPasswordOtp
                    ->where('email', $email)
                    ->where('otp_user_type', 'App\Models\Driver')
                    ->get();
        foreach($otps as $otp)
        {
            $otp->delete();
        }
    }

    public function createOtp($user, $otp)
    {
        $otp = $this->forgetPasswordOtp->create([
            'email' => $user->email,
            'otp' => $otp,
            'otp_user_id' => $user->id,
            'otp_user_type' => 'App\Models\Driver'
        ]);

        return $otp;
    }

    public function generateOtp()
    {
        $token = mt_rand(100000, 999999);
        return $token;
    }

    public function sendEmail(string $otp, $user)
    {
        try{
            Mail::to($user->email)->send(new ForgetPasswordEmail($otp));
            return true;
        } catch(\Exception $e) {
            dd($e);
            return null;
        }

    }

    public function verifyOtp($email, $otp)
    {
        $otp = $this->getUserOtp($email, $otp);
        // If Otp Exist
        if(!is_null($otp))
        {
            //Check the time is not expired
            //Curent Time
            $now = Carbon::now();
            //Difference between otp created and current time
            $difference = $now->diffInSeconds($otp->created_at);
            //If Difference is less than the time then mark this otp verified and delete it
            if( $difference < config('constant.otp.expiretime') ) {
                $this->markOtpVerified($otp);
                return true;
            } else {
                $this->deleteExistingOtps($email);
                return false;
            }
        } else {
            return false;
        }
    }

    public function markOtpVerified($otp)
    {
        $otp->verified = true;
        $otp->save();
    }

    public function getUserOtp($email, $otp)
    {
        $otp = $this->forgetPasswordOtp
                    ->where('email', $email)
                    ->where('otp', $otp)
                    ->first();
        return $otp;
    }

    public function resetPassword($email, $otp, $password)
    {

       $otp = $this->getUserOtp($email, $otp);
        //Check if otp exist
        //If it not exist
        if(is_null($otp)) {
            return false;
        }
       $user = $this->userReposiotry->getUserByEmail($email);;
       $update = $user->update([
            'password' => Hash::make($password)
       ]);
       if($update){
           $this->deleteExistingOtps($email);
           return true;
       } else {
           return false;
       }
    }
}
