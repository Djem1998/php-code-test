<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Base\BaseRepository;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleRepositoryInterface;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleStorageInterface;
use Tymeshift\PhpTest\Interfaces\CollectionFactoryInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    protected const ENTITY = 'schedule';

    /**
     * @param ScheduleStorageInterface $storage
     * @param EntityFactoryInterface $entityFactory
     * @param CollectionFactoryInterface $collectionFactory
     */
    public function __construct(
        ScheduleStorageInterface $storage,
        EntityFactoryInterface $entityFactory,
        CollectionFactoryInterface $collectionFactory
    ) {
        parent::__construct($storage, $entityFactory, $collectionFactory);
    }
}