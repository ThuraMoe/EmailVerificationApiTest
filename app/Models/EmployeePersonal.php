<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class EmployeePersonal extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // allow mass assignment
    public $guarded = [];

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail); // my notification
    }
}
