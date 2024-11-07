<?php

namespace App\Services;

use App\Exceptions\Exception;
use App\Models\User;

class UserService {
    public function save_user(array $user) {
        if($this->get_by_email($user['email'])) {
           throw new Exception('This e-mail is already in use'); 
        }

        return User::create($user);
    }

    public function get_by_email(string $email) {
        return User::where('email', $email)->first();
    }
}