<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

use Exception;

class InvalidDataProvidedException extends Exception
{
    private const MESSAGE = 'Invalid data provided in class ';
    private const CODE = 400;

    /**
     * @param string $class
     */
    public function __construct(string $class)
    {
        parent::__construct(self::MESSAGE . $class, self::CODE, null);
    }
}