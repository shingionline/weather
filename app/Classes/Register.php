<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function createUser($name, $surname, $email, $password)
    {
        $user = new User;
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return $user;
    }

}

