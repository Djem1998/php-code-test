<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

use Exception;

class StorageDataMissingException extends Exception
{
    private const MESSAGE = 'Storage data is empty for entity ';
    private const CODE = 400;

    /**
     * @param string $entity
     */
    public function __construct(string $entity)
    {
        parent::__construct(self::MESSAGE . $entity, self::CODE, null);
    }
}