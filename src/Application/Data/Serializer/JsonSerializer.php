<?php
declare(strict_types=1);

namespace App\Application\Data\Serializer;

use App\Application\Contract\DataSerializerInterface;
use JetBrains\PhpStorm\{NoReturn, Pure};
use League\Fractal\Serializer\JsonApiSerializer;

class JsonSerializer extends JsonApiSerializer implements DataSerializerInterface
{
    #[Pure]
    #[NoReturn]
    public function __construct(string $baseUrl)
    {
        parent::__construct($baseUrl);
    }
}