<?php

namespace App\Http;

class Response {
    public static function send_response(string $mesage, mixed $data, int $code = 200, bool $isError = false)
    {
        if($isError) {
            return response()->json([
                'mesage' => $mesage,
                'errors' => $data
            ], $code);
        }

        return response()->json([
            'mesage' => $mesage,
            'data' => $data
        ], $code);
    }
}