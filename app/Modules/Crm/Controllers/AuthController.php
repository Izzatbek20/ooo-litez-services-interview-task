<?php

namespace App\Modules\Crm\Controllers;

use App\Modules\Crm\DTOs\LoginInputDTO;
use App\Modules\Crm\DTOs\UserDTO;
use App\Modules\Crm\Requests\UserLoginRequest;
use App\Modules\Crm\Requests\UserRegisterRequest;
use App\Modules\Crm\Resources\UserResource;
use App\Modules\Crm\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $auth_service
    ) {}

    public function register(UserRegisterRequest $userRegister)
    {

        $userDto = UserDTO::fromRequest($userRegister);
        $user = $this->auth_service->register($userDto);

        return $this->success(new UserResource($user), 'Amalyot muvoffaqiyatli amalga oshirildi!', Response::HTTP_CREATED);
    }

    public function login(UserLoginRequest $userLoginRequest)
    {
        $loginData = new LoginInputDTO($userLoginRequest->email, $userLoginRequest->password);
        $result = $this->auth_service->login($loginData);

        return $this->success($result->toArray(), 'Tizimga kirish muvoffaqiyatli amalga oshirildi!');
    }
}
