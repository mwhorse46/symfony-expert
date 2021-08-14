<?php
declare(strict_types=1);

namespace App\Http\Abstract;

use App\Application\Contract\DataManagerInterface;
use App\Application\Contract\DataTransformerInterface;
use App\Database\Contract\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse
{
    protected ArrayCollection|EntityInterface|null $data = null;
    protected ResourceInterface|null $resource = null;
    protected DataManagerInterface $dataManager;
    protected DataTransformerInterface $transformer;
    protected string $resourceKey;

    public function __construct(DataManagerInterface $dataManager, DataTransformerInterface $transformer, string $resourceKey)
    {
        $this->dataManager = $dataManager;
        $this->transformer = $transformer;
        $this->resourceKey = $resourceKey;
    }

    public function data(ArrayCollection|EntityInterface $data): self
    {
        $this->data = $data;
        $this->resource = $this->resolveResource();
        return $this;
    }

    public function render(): JsonResponse
    {
        $data = $this->dataManager->createData($this->resource);
        return new JsonResponse($data);
    }

    private function resolveResource(): Collection|Item
    {
        $isEntity = $this->data instanceof EntityInterface;
        $resourceType = $isEntity ? Item::class : Collection::class;

        return new $resourceType($this->data, $this->transformer, $this->resourceKey);
    }
}