<?php
declare(strict_types=1);

namespace App\Application\Data\Transformer;

use App\Application\Abstract\AbstractDataTransformer;
use App\Database\Entity\User;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class UserTransformer extends AbstractDataTransformer
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    #[Pure]
    #[ArrayShape([
        'id' => "int|null",
        'email' => "null|string",
        'username' => "null|string",
        'name' => "null|string",
        'links' => "array"
    ])]
    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'name' => $user->getName(),
            'links' => [
                'self' => "{$this->baseUrl}/api/users/{$user->getUsername()}",
            ]
        ];
    }
}