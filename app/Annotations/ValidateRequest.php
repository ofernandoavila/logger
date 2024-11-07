<?php

namespace App\Annotations;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ValidateRequest {
    public string $controller;
    public string $action;
    public string $onGet;

    public function __construct(
        string $controller,
        string $action,
        bool $onGet = false
    )
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->onGet = $onGet;
    }
}