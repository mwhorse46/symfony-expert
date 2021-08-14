<?php
declare(strict_types=1);

namespace App\Application\Data\Manager;

use App\Application\Contract\DataManagerInterface;
use League\Fractal\Manager;
use League\Fractal\ScopeFactoryInterface;

class JsonDataManager extends Manager implements DataManagerInterface
{
    public function __construct(ScopeFactoryInterface $scopeFactory = null)
    {
        parent::__construct($scopeFactory);
    }
}