<?php

namespace App\Http\Request\User;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class UpdateUserRequest extends UserRequest
{
    #[Length(max: 255)]
    protected string|null $username;

    #[Length(max: 255)]
    protected string|null $name;

    #[Email]
    protected string|null $email;

    #[Length(min: 8, max: 255)]
    protected string|null $password;

    protected int|null $role;

    protected int|null $media;
}