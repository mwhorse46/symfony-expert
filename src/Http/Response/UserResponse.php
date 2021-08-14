<?php
declare(strict_types=1);

namespace App\Http\Response;

use App\Application\Contract\DataManagerInterface;
use App\Application\Contract\DataTransformerInterface;
use App\Http\Abstract\AbstractResponse;
use JetBrains\PhpStorm\Pure;

class UserResponse extends AbstractResponse
{
    #[Pure]
    public function __construct(DataManagerInterface $jsonManager, DataTransformerInterface $userTransformer)
    {
        parent::__construct(
            dataManager: $jsonManager,
            transformer: $userTransformer,
            resourceKey: 'users'
        );
    }
}