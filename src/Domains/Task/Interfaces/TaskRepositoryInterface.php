<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Interfaces;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $scheduleId
     * @return CollectionInterface
     * @throws InvalidCollectionDataProvidedException
     * @throws InvalidDataProvidedException
     * @throws StorageDataMissingException
     */
    public function getByScheduleId(int $scheduleId): CollectionInterface;
}