<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;

interface CollectionBuilderInterface
{
    /**
     * @param array $data
     * @param CollectionInterface $collection
     * @return CollectionInterface
     * @throws InvalidCollectionDataProvidedException
     */
    public function build(array $data, CollectionInterface $collection): CollectionInterface;
}