<?php

namespace App\Http\Controllers;

use App\Annotations\ValidateRequest;
use App\Exceptions\AccessUnauthorizedException;
use App\Http\Response;
use App\Models\User;
use App\Services\UserService;
use App\Validations\AuthValidation;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $service
    )
    {
        parent::__construct();
    }

    #[ValidateRequest(AuthValidation::class, 'login')]
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials))
            throw new AccessUnauthorizedException([ 'E-mail/Password does not match.' ]);

        return Response::send_response("Login successfully.", $this->respondWithToken($token));
    }

    #[ValidateRequest(AuthValidation::class, 'create_account')]
    public function create_account(Request $request)
    {
        if($user = $this->service->save_user([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            return Response::send_response("Account created successfully.", $user);
        }
    }


    public function me()
    {
        return Response::send_response("Account created successfully.", auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return Response::send_response("Successfully logged out.", []);
    }

    public function refresh()
    {
        return Response::send_response("Access token refreshed.", $this->respondWithToken(auth()->refresh()));
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
