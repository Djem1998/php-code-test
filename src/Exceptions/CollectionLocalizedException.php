<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Exceptions;

use Exception;
use Throwable;

class CollectionLocalizedException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code = 400, ?Throwable $previous = null)
    {
      parent::__construct($message, $code, $previous);
    }
}
