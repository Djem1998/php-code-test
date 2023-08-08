<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Base;

use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\CollectionFactoryInterface;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;
use Tymeshift\PhpTest\Interfaces\StorageInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected const ENTITY = '';

    /**
     * @var StorageInterface
     */
    protected StorageInterface $storage;

    /**
     * @var EntityFactoryInterface
     */
    protected EntityFactoryInterface $entityFactory;

    /**
     * @var CollectionFactoryInterface
     */
    protected CollectionFactoryInterface $collectionFactory;

    /**
     * @param StorageInterface $storage
     * @param EntityFactoryInterface $entityFactory
     * @param CollectionFactoryInterface $collectionFactory
     */
    public function __construct(
        StorageInterface $storage,
        EntityFactoryInterface $entityFactory,
        CollectionFactoryInterface $collectionFactory
    ) {
        $this->storage = $storage;
        $this->entityFactory = $entityFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id):EntityInterface
    {
        $data = $this->storage->getById($id);
        if (!$data) {
            throw new StorageDataMissingException(static::ENTITY);
        }

        return $this->entityFactory->createEntity($data);
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): CollectionInterface
    {
        $data = $this->storage->getByIds($ids);
        if (!$data) {
            throw new StorageDataMissingException(static::ENTITY);
        }

        return $this->collectionFactory->createCollection($data);
    }
}