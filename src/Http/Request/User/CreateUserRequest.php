<?php

namespace App\Http\Request\User;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateUserRequest extends UserRequest
{
    #[NotBlank]
    #[Length(max: 255)]
    protected string|null $username;

    #[NotBlank]
    #[Length(max: 255)]
    protected string|null $name;

    #[NotBlank]
    #[Email]
    protected string|null $email;

    #[NotBlank]
    #[Length(min: 8, max: 255)]
    protected string|null $password;

    #[NotBlank]
    protected int|null $role;

    protected int|null $media;
}