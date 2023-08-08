<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

interface StorageInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array;

    /**
     * @param array $ids
     * @return array
     */
    public function getByIds(array $ids): array;
}