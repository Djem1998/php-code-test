<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule\Builder;

use DateTime;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleItemInterface;
use Tymeshift\PhpTest\Interfaces\EntityBuilderInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

class ScheduleBuilder implements EntityBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function build(array $data, EntityInterface $entity): ScheduleItemInterface
    {
        /*** @var ScheduleItemInterface $entity */
        if (isset($data['id']) && is_int($data['id'])) {
            $entity->setId($data['id']);
        }

        if (isset($data['start_time']) && is_int($data['start_time'])) {
            $entity->setStartTime((new DateTime())->setTimestamp($data['start_time']));
        }

        if (isset($data['end_time']) && is_int($data['end_time'])) {
            $entity->setEndTime((new DateTime())->setTimestamp($data['end_time']));
        }

        if (isset($data['name']) && is_string($data['name'])) {
            $entity->setName($data['name']);
        }

        return $entity;
    }
}