<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;

interface RepositoryInterface
{
  /**
   * @param int $id
   * @return EntityInterface
   * @throws StorageDataMissingException
   */
    public function getById(int $id): EntityInterface;

  /**
   * @param array $ids
   * @return CollectionInterface
   * @throws StorageDataMissingException
   * @throws InvalidCollectionDataProvidedException
   */
    public function getByIds(array $ids): CollectionInterface;
}
