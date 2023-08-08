<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Tymeshift\PhpTest\Exceptions\CollectionLocalizedException;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\NoSuchEntityException;

interface CollectionInterface extends IteratorAggregate, Countable, ArrayAccess, JsonSerializable
{
    /**
     * Adds item to collection
     * @param EntityInterface $entity
     * @return $this
     */
    public function add(EntityInterface $entity): self;

    /**
     * @return EntityInterface[]
     */
    public function getItems(): array;

    /**
     * @param array $items
     * @return self
     * @throws InvalidCollectionDataProvidedException
     */
    public function setItems(array $items): self;

    /**
     * Creates array from collection
     * @return array
     */
    public function toArray(): array;

    /**
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string;

    /**
     * Searches for an element. $key will be transformed into getKey method and result of it will be compared to value
     * Comparison is strict
     * @param mixed $key
     * @param bool $value
     * @return mixed
     * @throws CollectionLocalizedException
     */
    public function search($key, $value);

    /**
     * Remove item from collection
     * @param mixed $key
     * @param mixed $value
     * @return bool
     */
    public function remove($key, $value): bool;

    /**
     * @param callable $callback
     * @return $this
     * @throws InvalidCollectionDataProvidedException
     */
    public function map(callable $callback): self;

    /**
     * @param callable $callback
     * @return $this
     * @throws InvalidCollectionDataProvidedException
     */
    public function filter(callable $callback): self;

    /**
     * Execute a callback over each item.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function each(callable $callback): self;

    /**
     * @param int $id
     * @return EntityInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): EntityInterface;

    /**
     * @param string $property
     * @return array
     */
    public function pluck(string $property): array;

    /**
     * @param string $property
     * @return self
     * @throws InvalidCollectionDataProvidedException
     */
    public function getAssoc(string $property = 'id'): self;

    /**
     * @return int[]
     */
    public function getIds(): array;

    /**
     * @return EntityInterface
     */
    public function last(): EntityInterface;
}
