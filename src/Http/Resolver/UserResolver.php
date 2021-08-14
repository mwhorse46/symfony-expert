<?php
declare(strict_types=1);

namespace App\Http\Resolver;

use App\Application\Exception\UserNotExistsException;
use App\Application\Service\UserService;
use App\Database\Entity\User;
use Generator;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UserResolver implements ArgumentValueResolverInterface
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Pure]
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if ($argument->getType() === User::class) {
            return true;
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $username = $request->get('username');
        $user = $this->userService->getByUsername($username);

        if (!$user) {
            throw new UserNotExistsException($username);
        }

        yield $this->userService->getByUsername($username);
    }
}