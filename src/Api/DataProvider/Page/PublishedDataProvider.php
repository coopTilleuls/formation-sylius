<?php

namespace App\Api\DataProvider\Page;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Cms\Page;
use App\Repository\Admin\PageRepository;

class PublishedDataProvider implements RestrictedDataProviderInterface, CollectionDataProviderInterface
{
    public function __construct(private PageRepository $repository)
    {
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Page::class && $operationName === 'shop_get';
    }

    public function getCollection(string $resourceClass, string $operationName = null): array
    {
        return $this->repository->findBy([
            'status' => 'published',
        ]);
    }
}
