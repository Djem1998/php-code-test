<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule\Interfaces;

use DateTime;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

interface ScheduleItemInterface extends EntityInterface
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
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

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
     * @return DateTime
     */
    public function getEndTime(): DateTime;

    /**
     * @param DateTime $endTime
     * @return self
     */
    public function setEndTime(DateTime $endTime): self;
}