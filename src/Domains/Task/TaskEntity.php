<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use DateTime;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskItemInterface;

class TaskEntity implements TaskItemInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $scheduleId;

    /**
     * @var DateTime
     */
    private DateTime $startTime;

    /**
     * @var int
     */
    private int $duration;

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): TaskItemInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @inheritDoc
     */
    public function setScheduleId(int $scheduleId): TaskItemInterface
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setStartTime(DateTime $startTime): TaskItemInterface
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    /**
     * @inheritDoc
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @inheritDoc
     */
    public function setDuration(int $duration): TaskItemInterface
    {
        $this->duration = $duration;

        return $this;
    }
}