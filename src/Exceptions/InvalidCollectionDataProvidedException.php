<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

use Exception;

class InvalidCollectionDataProvidedException extends Exception
{
    private const MESSAGE = 'Invalid data provided for building collection';
    private const CODE = 500;

    public function __construct()
    {
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
