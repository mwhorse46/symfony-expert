<?php

namespace App\Application\Contract;

use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;

interface DataManagerInterface
{
    public function createData(ResourceInterface $resource, $scopeIdentifier = null, Scope $parentScopeInstance = null);
}