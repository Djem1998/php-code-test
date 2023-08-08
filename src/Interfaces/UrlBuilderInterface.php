<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;

interface UrlBuilderInterface
{
    /**
     * @param string $method
     * @return self
     */
    public function setMethod(string $method): self;

    /**
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self;

    /**
     * @param string|array|int $params
     * @return self
     */
    public function setParams(string|array|int $params): self;

    /**
     * @return string
     * @throws InvalidDataProvidedException
     */
    public function build(): string;
}