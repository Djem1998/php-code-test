<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Builder;

use DateTime;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskItemInterface;
use Tymeshift\PhpTest\Interfaces\EntityBuilderInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

class TaskBuilder implements EntityBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function build(array $data, EntityInterface $entity): TaskItemInterface
    {
        /*** @var TaskItemInterface $entity */
        if (isset($data['id']) && is_int($data['id'])) {
            $entity->setId($data['id']);
        }

        if (isset($data['start_time']) && is_int($data['start_time'])) {
            $entity->setStartTime((new DateTime())->setTimestamp($data['start_time']));
        }

        if (isset($data['duration']) && is_int($data['duration'])) {
            $entity->setDuration($data['duration']);
        }

        if (isset($data['schedule_id']) && is_int($data['schedule_id'])) {
            $entity->setScheduleId($data['schedule_id']);
        }

        return $entity;
    }
}