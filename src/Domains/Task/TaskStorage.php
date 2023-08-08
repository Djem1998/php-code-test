<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskStorageInterface;
use Tymeshift\PhpTest\Exceptions\InvalidDataProvidedException;
use Tymeshift\PhpTest\Interfaces\UrlBuilderInterface;

class TaskStorage implements TaskStorageInterface
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var UrlBuilderInterface
     */
    private UrlBuilderInterface $urlBuilder;

    /**
     * @param HttpClientInterface $httpClient
     * @param UrlBuilderInterface $urlBuilder
     */
    public function __construct(HttpClientInterface $httpClient, UrlBuilderInterface $urlBuilder)
    {
        $this->client = $httpClient;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function getByScheduleId(int $id): array
    {
        $url = $this->urlBuilder->setMethod(HttpClientInterface::METHOD_GET)
            ->setUri(self::SCHEDULE_TASKS_URI)
            ->setParams($id)
            ->build();

        return $this->client->request(HttpClientInterface::METHOD_GET, $url);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataProvidedException
     */
    public function getByIds(array $ids): array
    {
        $url = $this->urlBuilder->setMethod(HttpClientInterface::METHOD_GET)
            ->setUri(self::TASKS_URI)
            ->setParams($ids)
            ->build();

        return $this->client->request(HttpClientInterface::METHOD_GET, $url);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataProvidedException
     */
    public function getById(int $id): array
    {
        $url = $this->urlBuilder->setMethod(HttpClientInterface::METHOD_GET)
            ->setUri(self::TASKS_URI)
            ->setParams($id)
            ->build();

        return $this->client->request(HttpClientInterface::METHOD_GET, $url);
    }
}