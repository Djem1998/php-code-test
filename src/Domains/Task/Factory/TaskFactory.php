<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task\Factory;

use Tymeshift\PhpTest\Domains\Task\TaskEntity;
use Tymeshift\PhpTest\Interfaces\EntityBuilderInterface;
use Tymeshift\PhpTest\Interfaces\EntityFactoryInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

class TaskFactory implements EntityFactoryInterface
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
            return $this->builder->build($data, new TaskEntity());
        }

        return new TaskEntity();
    }
}
