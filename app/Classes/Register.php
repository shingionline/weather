<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function createUser($name, $surname, $email)
    {
        $new_password = bin2hex(openssl_random_pseudo_bytes(4));

        $user = new User;
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->password = Hash::make($new_password);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return $user;
    }

}

