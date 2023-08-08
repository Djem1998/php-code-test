<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;

interface CollectionFactoryInterface
{
    /**
     * @param array|null $data
     * @return CollectionInterface
     * @throws InvalidCollectionDataProvidedException
     */
    public function createCollection(?array $data = null): CollectionInterface;
}