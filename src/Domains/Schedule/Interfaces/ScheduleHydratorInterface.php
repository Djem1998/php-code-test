<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule\Interfaces;

use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskItemInterface;

interface ScheduleHydratorInterface
{
    /**
     * @param TaskItemInterface $taskItem
     * @return ScheduleItemInterface
     */
    public function hydrate(TaskItemInterface $taskItem): ScheduleItemInterface;
}