<?php

namespace App\Annotations;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ValidateRequest {
    public string $controller;
    public string $action;

    public function __construct(
        string $controller,
        string $action
    )
    {
        $this->controller = $controller;
        $this->action = $action;
    }
}