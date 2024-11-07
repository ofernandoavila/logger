<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected array $data;

    public function __construct()
    {
        $this->data['title'] = env('APP_NAME', 'app_name');
    }
}
