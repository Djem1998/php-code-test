<?php

declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Exception;
use Mockery;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Builder\UrlBuilder;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Task\Builder\TaskBuilder;
use Tymeshift\PhpTest\Domains\Task\Builder\TaskCollectionBuilder;
use Tymeshift\PhpTest\Domains\Task\Factory\TaskCollectionFactory;
use Tymeshift\PhpTest\Domains\Task\Factory\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskStorageInterface;
use Tymeshift\PhpTest\Domains\Task\TaskCollection;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use UnitTester;

class TaskCest
{
    /**
     * @var TaskRepository|null
     */
    private ?TaskRepository $taskRepository;

    /**
     * @var MockInterface|null
     */
    private ?MockInterface $httpClientMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        //@TODO better to introduce DI container to base on automatic injections
        $this->httpClientMock = Mockery::mock(HttpClientInterface::class);
        $this->taskRepository = new TaskRepository(
            new TaskStorage($this->httpClientMock, new UrlBuilder()),
            new TaskFactory(new TaskBuilder()),
            new TaskCollectionFactory(new TaskCollectionBuilder(new TaskFactory(new TaskBuilder())))
        );
    }

    /**
     * @return void
     */
    public function _after(): void
    {
        $this->taskRepository = null;
        $this->httpClientMock = null;
        Mockery::close();
    }

    /**
     * @param Example $example
     * @param UnitTester $tester
     * @return void
     * @dataProvider tasksDataProvider
     */
    public function testGetTasks(Example $example, UnitTester $tester): void
    {
        $scheduleId = 1;
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(HttpClientInterface::METHOD_GET, TaskStorageInterface::SCHEDULE_TASKS_URI . $scheduleId)
            ->andReturn([...$example]);
        $tasks = $this->taskRepository->getByScheduleId($scheduleId);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
    }

    /**
     * @param UnitTester $tester
     * @return void
     */
    public function testGetTasksFailed(UnitTester $tester): void
    {
        $tester->expectThrowable(Exception::class, function (){
            $this->taskRepository->getByScheduleId(4);
        });
    }

    /**
     * @return array[]
     */
    public function tasksDataProvider(): array
    {
        return [
            [
                ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600],
            ]
        ];
    }
}