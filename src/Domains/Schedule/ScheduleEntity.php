<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use DateTime;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleItemInterface;

class ScheduleEntity implements ScheduleItemInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var DateTime
     */
    private DateTime $startTime;

    /**
     * @var DateTime
     */
    private DateTime $endTime;

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
    public function setId(int $id): ScheduleItemInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): ScheduleItemInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    /**
     * @inheritDoc
     */
    public function setStartTime(DateTime $startTime): ScheduleItemInterface
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    /**
     * @inheritDoc
     */
    public function setEndTime(DateTime $endTime): ScheduleItemInterface
    {
        $this->endTime = $endTime;

        return $this;
    }
}