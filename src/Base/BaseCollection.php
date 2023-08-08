<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Base;

use ArrayIterator;
use Tymeshift\PhpTest\Exceptions\CollectionLocalizedException;
use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Exceptions\NoSuchEntityException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;

abstract class BaseCollection implements CollectionInterface
{
    /** @var EntityInterface[] */
    protected array $items = [];

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function setItems(array $items): CollectionInterface
    {
        foreach ($items as $key => $item) {
            if ($this->isEntity($item)) {
                $this->items[$key] = $item;
            } else {
                throw new InvalidCollectionDataProvidedException();
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(EntityInterface $entity): CollectionInterface
    {
        $this->items[] = $entity;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray():array
    {
        $result = [];

        foreach ($this->items as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }

  /**
   * @inheritDoc
   */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @inheritDoc
     */
    public function search($key, $value)
    {
        foreach ($this->items as $item) {
            if ($item->{'get' . $key}() === $value) {
                return $item;
            }
        }

        throw new CollectionLocalizedException("Item with field $key and value $value doesn't exist in collection");
    }

    /**
     * @inheritDoc
     */
    public function remove($key, $value): bool
    {
        foreach ($this->items as $index => $item) {
            if ($item->{'get' . $key}() === $value) {
                unset($this->items[$index]);
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function map(callable $callback): CollectionInterface
    {
        $keys = array_keys($this->items);

        $newItems = [];
        foreach ($this->items as $value) {
            $clonedValue = clone $value;
            $newItems[] = $callback($clonedValue);
        }

        return new static(array_combine($keys, $newItems));
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $callback): CollectionInterface
    {
        $newItems = [];
        foreach ($this->items as $value) {
            $clonedValue = clone $value;
            if ($callback($clonedValue)) {
                $newItems[] = $clonedValue;
            }
        }

        return new static($newItems);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * @inheritDoc
     * @throws InvalidCollectionDataProvidedException
     */
    public function offsetSet($key, $value): void
    {
        if (!$this->isEntity($value)) {
            throw new InvalidCollectionDataProvidedException();
        }
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @param self $item
     * @return bool
     */
    protected function isEntity(self $item): bool
    {
        return ($item instanceof EntityInterface);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function each(callable $callback): CollectionInterface
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): EntityInterface
    {
        foreach ($this->items as $entity) {
            if ($entity->getId() === $id) {
                return $entity;
            }
        }
        throw new NoSuchEntityException($id);
    }

    /**
     * @inheritDoc
     */
    public function pluck(string $property): array
    {
        $data = [];
        foreach ($this->items as $entity) {
            $data[] = $entity->{'get' . ucfirst($property)}();
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getAssoc(string $property = 'id'): CollectionInterface
    {
        $items = [];
        foreach ($this->items as $index => $entity) {
            $newKey = $entity->{'get' . ucfirst($property)}();
            $items[$newKey] = $this->items[$index];
        }

        return new static($items);
    }

    /**
     * @inheritDoc
     */
    public function getIds(): array
    {
        $result = [];
        foreach ($this->items as $entity) {
            $result[] = $entity->getId();
        }

        return array_unique($result);
    }

    /**
     * @inheritDoc
     */
    public function last(): EntityInterface
    {
        $lastItem = end($this->items);
        reset($this->items);

        return $lastItem;
    }
}
