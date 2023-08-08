<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

use Exception;
use Throwable;

class NoSuchEntityException extends Exception
{
    private const CODE = 400;

    /**
     * @param int $entityId
     * @param Throwable|null $previous
     */
    public function __construct(int $entityId, ?Throwable $previous = null)
    {
      parent::__construct("No such entity with id $entityId", self::CODE, $previous);
    }
}
