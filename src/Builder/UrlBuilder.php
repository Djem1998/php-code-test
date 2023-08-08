<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Builder;

use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;
use Tymeshift\PhpTest\Interfaces\UrlBuilderInterface;

class UrlBuilder implements UrlBuilderInterface
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $uri;

    /**
     * @var array
     */
    private array $params;

    /**
     * @inheritDoc
     */
    public function setMethod(string $method): UrlBuilderInterface
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUri(string $uri): UrlBuilderInterface
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setParams(array|int|string $params): UrlBuilderInterface
    {
        if (is_array($params)) {
            $this->params += $params;
        } else {
            $this->params[] = $params;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $url = '';
        if (!$this->uri || !$this->method) {
            throw new InvalidDataProvidedException(self::class);
        }
        if ($this->method === HttpClientInterface::METHOD_GET) {
            $url .= $this->uri;
            $paramsCount = count($this->params);
            foreach ($this->params as $key => $param) {
                $url .= $param;
                if ($paramsCount > 1 && $key !== ($paramsCount - 1)) {
                    $url .= ',';
                }
            }
        }

        return $url;
    }
}