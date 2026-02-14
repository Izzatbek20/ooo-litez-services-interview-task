<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Requests\UserLoginRequest;

readonly class LoginInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    public static function fromRequest(UserLoginRequest $userLogin)
    {
        return new self(
            email: $userLogin->email,
            password: $userLogin->password,
        );
    }

    public function toArray()
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
