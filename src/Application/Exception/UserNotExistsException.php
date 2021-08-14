<?php
declare(strict_types=1);

namespace App\Application\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\Exception\ExceptionInterface;
use Throwable;

class UserNotExistsException extends \RuntimeException implements ExceptionInterface
{
    #[Pure]
    public function __construct(string $username, $code = 0, Throwable $previous = null)
    {
        $message = "User with username {$username} not exists";
        parent::__construct($message, $code, $previous);
    }
}