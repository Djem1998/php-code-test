<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Factory;

use Tymeshift\PhpTest\Domains\Task\TaskCollection;
use Tymeshift\PhpTest\Interfaces\CollectionBuilderInterface;
use Tymeshift\PhpTest\Interfaces\CollectionFactoryInterface;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;

class TaskCollectionFactory implements CollectionFactoryInterface
{
    /**
     * @var CollectionBuilderInterface
     */
    private CollectionBuilderInterface $collectionBuilder;

    /**
     * @param CollectionBuilderInterface $collectionBuilder
     */
    public function __construct(CollectionBuilderInterface $collectionBuilder)
    {
        $this->collectionBuilder = $collectionBuilder;
    }

    /**
     * @inheritDoc
     */
    public function createCollection(?array $data = null): CollectionInterface
    {
        if ($data) {
            return $this->collectionBuilder->build($data, new TaskCollection());
        }

        return new TaskCollection();
    }
}