<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgetPasswordOtp extends Model
{
    protected $fillable = ['email', 'otp', 'otp_user_id', 'otp_user_type'];
}
