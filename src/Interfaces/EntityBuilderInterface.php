<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

interface EntityBuilderInterface
{
    /**
     * @param array $data
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function build(array $data, EntityInterface $entity): EntityInterface;
}