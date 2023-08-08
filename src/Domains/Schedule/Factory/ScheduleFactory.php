<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule\Factory;

use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Interfaces\EntityBuilderInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

class ScheduleFactory implements EntityFactoryInterface
{
    /**
     * @var EntityBuilderInterface
     */
    private EntityBuilderInterface $builder;

    /**
     * @param EntityBuilderInterface $builder
     */
    public function __construct(EntityBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @inheritDoc
     */
    public function createEntity(?array $data = null): EntityInterface
    {
        if ($data) {
            return $this->builder->build($data, new ScheduleEntity());
        }

        return new ScheduleEntity();
    }
}