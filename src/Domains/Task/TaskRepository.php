<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Base\BaseRepository;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskRepositoryInterface;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskStorageInterface;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\CollectionFactoryInterface;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    protected const ENTITY = 'task';

    /**
     * @param TaskStorageInterface $storage
     * @param EntityFactoryInterface $entityFactory
     * @param CollectionFactoryInterface $collectionFactory
     */
    public function __construct(
        TaskStorageInterface $storage,
        EntityFactoryInterface $entityFactory,
        CollectionFactoryInterface $collectionFactory
    ) {
        parent::__construct($storage, $entityFactory, $collectionFactory);
    }

    /**
     * @inheritDoc
     */
    public function getByScheduleId(int $scheduleId): CollectionInterface
    {
        $data = $this->storage->getByScheduleId($scheduleId);
        if (!$data) {
            throw new StorageDataMissingException(self::ENTITY);
        }

        return $this->collectionFactory->createCollection($data);
    }
}