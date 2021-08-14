<?php
declare(strict_types=1);

namespace App\Application\Abstract;

use App\Application\Contract\DataTransformerInterface;
use League\Fractal\TransformerAbstract;

abstract class AbstractDataTransformer extends TransformerAbstract implements DataTransformerInterface
{
    //
}