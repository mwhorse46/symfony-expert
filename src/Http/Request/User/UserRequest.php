<?php

namespace App\Http\Request\User;

use App\Http\Contract\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRequest implements RequestInterface
{
    protected string|null $username;
    protected string|null $name;
    protected string|null $email;
    protected string|null $password;
    protected int|null $role;
    protected int|null $media;

    public function __construct(Request $request)
    {
        $this->username = $request->get('username');
        $this->name = $request->get('name');
        $this->email = $request->get('email');
        $this->password = $request->get('password');
        $this->role = $request->get('role');
        $this->media = $request->get('media');
    }

    public function username(): string|null
    {
        return $this->username;
    }

    public function name(): string|null
    {
        return $this->name;
    }

    public function email(): string|null
    {
        return $this->email;
    }

    public function password(): string|null
    {
        return $this->password;
    }

    public function role(): int|null
    {
        return $this->role;
    }

    public function media(): int|null
    {
        return $this->media;
    }
}