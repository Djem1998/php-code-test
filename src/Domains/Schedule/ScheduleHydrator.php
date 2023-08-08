<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleFactory;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleHydratorInterface;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleItemInterface;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskItemInterface;

class ScheduleHydrator implements ScheduleHydratorInterface
{
    /**
     * @var ScheduleFactory
     */
    private ScheduleFactory $scheduleFactory;

    /**
     * @param ScheduleFactory $scheduleFactory
     */
    public function __construct(ScheduleFactory $scheduleFactory)
    {
        $this->scheduleFactory = $scheduleFactory;
    }

    /**
     * @inheritDoc
     */
    public function hydrate(TaskItemInterface $taskItem): ScheduleItemInterface
    {
        /*** @var ScheduleItemInterface $scheduleItem */
        $scheduleItem = $this->scheduleFactory->createEntity();
        $scheduleItem->setId($taskItem->getScheduleId());
        $scheduleItem->setStartTime($taskItem->getStartTime());
        $scheduleItem->setEndTime(
            $taskItem->getStartTime()->modify('+' . $taskItem->getDuration() . ' seconds')
        );
        $scheduleItem->setName('');

        return $scheduleItem;
    }
}