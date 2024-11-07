<?php

namespace App\Exceptions;

class RequestValidationFailedException extends \Exception {
    public function __construct(
        string $message,
        public array $options,
        public string $type = 'error'
    )
    {
        parent::__construct($message);
    }

    public function getType()
    {
        return $this->type;
    }
}