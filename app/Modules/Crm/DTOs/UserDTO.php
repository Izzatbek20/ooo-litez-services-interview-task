<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Enums\UserRoleEnum;
use App\Modules\Crm\Requests\UserRegisterRequest;

readonly class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?UserRoleEnum $role,
    ) {
    }

    public static function fromRequest(UserRegisterRequest $userRegister)
    {
        return new self(
            name: $userRegister->name,
            email: $userRegister->email,
            password: $userRegister->password,
            role: $userRegister?->enum('role', UserRoleEnum::class)
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
        ];
    }
}
