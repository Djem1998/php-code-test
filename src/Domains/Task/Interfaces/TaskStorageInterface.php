<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Interfaces;

use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;
use Tymeshift\PhpTest\Interfaces\StorageInterface;

interface TaskStorageInterface extends StorageInterface
{
    public const SCHEDULE_TASKS_URI = '/tasks/schedule/';
    public const TASKS_URI = '/tasks/';

    /**
     * @param int $id
     * @return array
     * @throws InvalidDataProvidedException
     */
    public function getByScheduleId(int $id): array;
}