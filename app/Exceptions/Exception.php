<?php

namespace App\Exceptions;

class Exception extends \Exception {
    public function __construct(
        string $message,
        int $code = 500,
        public mixed $params = []
    )
    {
        $this->code = $code;
        parent::__construct($message);
    }

    public function get_simple_stack()
    {
        $filter = array_filter(explode("\n", $this->getTraceAsString()), function($value) {
            if(strpos($value, "App\\")) {
                return $value;
            }
        });

        return $filter;
    }
    
    public function get_detailed_stack()
    {
        $stacks = explode("\n", $this->getTraceAsString());
        
        $list = [];

        foreach($stacks as $stack) {
            $row = [];

            $stack = explode(" ", $stack);

            $row['level'] = isset($stack[0]) ? intval(str_replace("#", "", $stack[0])) : '';
            $row['file'] = isset($stack[1]) ? $stack[1] : '';
            $row['method'] = isset($stack[2]) ? $stack[2] : '';

            $list[] = $row;
        }

        return $list;
    }

    public function to_response()
    {
        return [
            'code' => $this->code,
            'params' => $this->params,
            'simple_trace' => $this->get_simple_stack(),
            'detailed_trace' => $this->get_detailed_stack(),
            'stack_trace' => explode("\n", $this->getTraceAsString()),
        ];
    }
}