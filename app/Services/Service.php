<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class Service {
    public function get_logged_user()
    {
        return Auth::user();
    }
}