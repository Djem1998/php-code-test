<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleCollectionFactory;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleHydratorInterface;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleItemInterface;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleRepositoryInterface;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskRepositoryInterface;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;

class ScheduleService
{
    /**
     * @var ScheduleRepositoryInterface
     */
    private ScheduleRepositoryInterface $scheduleRepository;

    /**
     * @var TaskRepositoryInterface
     */
    private TaskRepositoryInterface $taskRepository;

    /**
     * @var ScheduleCollectionFactory
     */
    private ScheduleCollectionFactory $scheduleCollectionFactory;

    /**
     * @var ScheduleHydratorInterface $scheduleHydrator
     */
    private ScheduleHydratorInterface $scheduleHydrator;

    /**
     * @param ScheduleRepositoryInterface $scheduleRepository
     * @param TaskRepositoryInterface $taskRepository
     * @param ScheduleCollectionFactory $scheduleCollectionFactory
     * @param ScheduleHydratorInterface $scheduleHydrator
     */
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
        TaskRepositoryInterface $taskRepository,
        ScheduleCollectionFactory $scheduleCollectionFactory,
        ScheduleHydratorInterface $scheduleHydrator
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->taskRepository = $taskRepository;
        $this->scheduleCollectionFactory = $scheduleCollectionFactory;
        $this->scheduleHydrator = $scheduleHydrator;
    }

    /**
     * @param int $scheduleId
     * @return ScheduleItemInterface[]
     * @throws StorageDataMissingException
     * @throws InvalidCollectionDataProvidedException
     * @throws InvalidDataProvidedException
     */
    public function getScheduleById(int $scheduleId): array
    {
        $schedule = $this->scheduleRepository->getById($scheduleId);
        $taskCollection = $this->taskRepository->getByScheduleId($scheduleId);
        $scheduleCollection = $this->scheduleCollectionFactory->createCollection();
        $scheduleCollection->add($schedule);
        foreach ($taskCollection->getItems() as $taskItem) {
            $scheduleCollection->add($this->scheduleHydrator->hydrate($taskItem));
        }

        return $scheduleCollection->getItems();
    }
}