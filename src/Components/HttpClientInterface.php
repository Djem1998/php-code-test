<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Components;

interface HttpClientInterface
{
    public const METHOD_GET = 'GET';

    /**
     * Returns json decoded response body
     * @param string $method
     * @param string $uri
     * @return array
     */
    public function request(string $method, string $uri): array;
}
