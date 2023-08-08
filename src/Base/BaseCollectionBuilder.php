<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Base;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Interfaces\CollectionBuilderInterface;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;

abstract class BaseCollectionBuilder implements CollectionBuilderInterface
{
    /**
     * @var EntityFactoryInterface
     */
    private EntityFactoryInterface $entityFactory;

    /**
     * @param EntityFactoryInterface $entityFactory
     */
    public function __construct(EntityFactoryInterface $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    /**
     * @inheritDoc
     */
    public function build(array $data, CollectionInterface $collection): CollectionInterface
    {
        foreach ($data as $item) {
            if (is_array($item)) {
                $collection->add($this->entityFactory->createEntity($item));
            }  else {
                throw new InvalidCollectionDataProvidedException();
            }
        }

        return $collection;
    }
}