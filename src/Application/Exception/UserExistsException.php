<?php
declare(strict_types=1);

namespace App\Application\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\Exception\ExceptionInterface;
use Throwable;

class UserExistsException extends \RuntimeException implements ExceptionInterface
{
    #[Pure]
    public function __construct(string $email, $code = 0, Throwable $previous = null)
    {
        $message = "User with email {$email} already exists";
        parent::__construct($message, $code, $previous);
    }
}