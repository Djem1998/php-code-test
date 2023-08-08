<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Interfaces;

use DateTime;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

interface TaskItemInterface extends EntityInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self;

    /**
     * @return int
     */
    public function getScheduleId(): int;

    /**
     * @param int $scheduleId
     * @return self
     */
    public function setScheduleId(int $scheduleId): self;

    /**
     * @param DateTime $startTime
     * @return self
     */
    public function setStartTime(DateTime $startTime): self;

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime;

    /**
     * @return int
     */
    public function getDuration(): int;

    /**
     * @param int $duration
     * @return self
     */
    public function setDuration(int $duration): self;
}