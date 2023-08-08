<?php

declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Exception;
use Mockery;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Builder\UrlBuilder;
use Tymeshift\PhpTest\Components\DatabaseInterface;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Schedule\Builder\ScheduleBuilder;
use Tymeshift\PhpTest\Domains\Schedule\Builder\ScheduleCollectionBuilder;
use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleCollectionFactory;
use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleFactory;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleHydrator;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleRepository;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleService;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Domains\Task\Builder\TaskBuilder;
use Tymeshift\PhpTest\Domains\Task\Builder\TaskCollectionBuilder;
use Tymeshift\PhpTest\Domains\Task\Factory\TaskCollectionFactory;
use Tymeshift\PhpTest\Domains\Task\Factory\TaskFactory;
use Tymeshift\PhpTest\Domains\Task\Interfaces\TaskStorageInterface;
use Tymeshift\PhpTest\Domains\Task\TaskRepository;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use UnitTester;

class ScheduleServiceCest
{
    /**
     * @var MockInterface|null
     */
    private ?MockInterface $db;

    /**
     * @var MockInterface|null
     */
    private ?MockInterface $httpClientMock;

    /**
     * @var ScheduleService|null
     */
    private ?ScheduleService $scheduleService;

    /**
     * @return void
     */
    public function _before(): void
    {
        //@TODO better to introduce DI container to base on automatic injections
        $this->httpClientMock = Mockery::mock(HttpClientInterface::class);
        $this->db = Mockery::mock(DatabaseInterface::class);
        $this->scheduleService = new ScheduleService(
            new ScheduleRepository(
                new ScheduleStorage($this->db),
                new ScheduleFactory(new ScheduleBuilder()),
                new ScheduleCollectionFactory(new ScheduleCollectionBuilder(new ScheduleFactory(new ScheduleBuilder())))
            ),
            new TaskRepository(
                new TaskStorage($this->httpClientMock, new UrlBuilder()),
                new TaskFactory(new TaskBuilder()),
                new TaskCollectionFactory(new TaskCollectionBuilder(new TaskFactory(new TaskBuilder())))
            ),
            new ScheduleCollectionFactory(new ScheduleCollectionBuilder(new ScheduleFactory(new ScheduleBuilder()))),
            new ScheduleHydrator(new ScheduleFactory(new ScheduleBuilder()))
        );
    }

    /**
     * @param Example $example
     * @param UnitTester $tester
     * @return void
     * @dataProvider combinedDataProvider
     */
    public function testGetByIdSuccess(Example $example, UnitTester $tester): void
    {
        $tasks = [...$example];
        $schedules = $tasks[3];
        unset($tasks[3]);
        $scheduleId = 1;
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(HttpClientInterface::METHOD_GET, TaskStorageInterface::SCHEDULE_TASKS_URI . $scheduleId)
            ->andReturn($tasks);
        $this->db
            ->shouldReceive('query')
            ->with('SELECT * FROM schedules WHERE id=:id', ["id" => $scheduleId])
            ->andReturn($schedules);
        $scheduleItems = $this->scheduleService->getScheduleById($scheduleId);
        $tester->assertCount(4, $scheduleItems);
        $tester->assertInstanceOf(ScheduleEntity::class, end($scheduleItems));
    }

    /**
     * @param UnitTester $tester
     * @return void
     */
    public function testGetByIdFail(UnitTester $tester): void
    {
        $tester->expectThrowable(Exception::class, function (){
            $this->scheduleService->getScheduleById(4);
        });
    }

    /**
     * @return void
     */
    public function _after(): void
    {
        $this->db = null;
        $this->scheduleService = null;
        $this->httpClientMock = null;
        Mockery::close();
    }

    /**
     * @return array[]
     */
    protected function combinedDataProvider(): array
    {
        return [
            [
                ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600],
                ['id' => 1, 'start_time' => 1631232000, 'end_time' => 1631232000 + 86400, 'name' => 'Test']
            ]
        ];
    }
}