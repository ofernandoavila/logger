<?php

namespace App\Exceptions;

class AccessUnauthorizedException extends Exception {
    public function __construct(public array $errors)
    {
        parent::__construct('Access unauthorized', 403, $this->errors);
    }
}