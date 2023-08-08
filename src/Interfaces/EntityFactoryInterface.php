<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

interface EntityFactoryInterface
{
    /**
     * @param array|null $data
     * @return EntityInterface
     */
    public function createEntity(?array $data = null): EntityInterface;
}
