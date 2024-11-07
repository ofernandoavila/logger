<?php

namespace App\Exceptions;

class RequestValidationFailedException extends Exception {
    public function __construct(public mixed $errors)
    {
        parent::__construct('Validation failed', 403, $errors);
    }
}