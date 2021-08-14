<?php
declare(strict_types=1);

namespace App\Http\Resolver;

use App\Http\Contract\RequestInterface;
use Generator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $reflection = new ReflectionClass($argument->getType());
        if ($reflection->implementsInterface(RequestInterface::class)) {
            return true;
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        // creating new instance of custom request DTO
        $class = $argument->getType();
        $dto = new $class($request);

        // throw bad request exception in case of invalid request data
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string)$errors);
        }

        yield $dto;
    }
}