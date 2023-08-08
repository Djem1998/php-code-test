<?php

declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Mockery;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Domains\Schedule\Builder\ScheduleBuilder;
use Tymeshift\PhpTest\Domains\Schedule\Builder\ScheduleCollectionBuilder;
use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleCollectionFactory;
use Tymeshift\PhpTest\Domains\Schedule\Factory\ScheduleFactory;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleStorageInterface;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleRepository;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use UnitTester;

class ScheduleCest
{
    /**
     * @var MockInterface|null
     */
    private ?MockInterface $scheduleStorageMock;

    /**
     * @var ScheduleRepository|null
     */
    private ?ScheduleRepository $scheduleRepository;

    /**
     * @return void
     */
    public function _before(): void
    {
        //@TODO better to introduce DI container to base on automatic injections
        $this->scheduleStorageMock = Mockery::mock(ScheduleStorage::class);
        $this->scheduleRepository = new ScheduleRepository(
            $this->scheduleStorageMock,
            new ScheduleFactory(new ScheduleBuilder()),
            new ScheduleCollectionFactory(new ScheduleCollectionBuilder(new ScheduleFactory(new ScheduleBuilder())))
        );
    }

    /**
     * @return void
     */
    public function _after(): void
    {
        $this->scheduleRepository = null;
        $this->scheduleStorageMock = null;
        Mockery::close();
    }

    /**
     * @param Example $example
     * @param UnitTester $tester
     * @return void
     * @dataProvider scheduleProvider
     */
    public function testGetByIdSuccess(Example $example, UnitTester $tester): void
    {
        ['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name] = $example;
        $data = ['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name];

        $this->scheduleStorageMock
            ->shouldReceive('getById')
            ->with($id)
            ->andReturn(['id' => $id, 'start_time' => $startTime, 'end_time' => $endTime, 'name' => $name]);

        $entity = $this->scheduleRepository->getById($id);
        $tester->assertEquals($id, $entity->getId());
        $tester->assertEquals($startTime, $entity->getStartTime()->getTimestamp());
        $tester->assertEquals($endTime, $entity->getEndTime()->getTimestamp());
    }

    /**
     * @param UnitTester $tester
     * @return void
     */
    public function testGetByIdFail(UnitTester $tester): void
    {
        $this->scheduleStorageMock
            ->shouldReceive('getById')
            ->with(4)
            ->andReturn([]);
        $tester->expectThrowable(StorageDataMissingException::class, function () {
            $this->scheduleRepository->getById(4);
        });
    }

    /**
     * @return array[]
     */
    protected function scheduleProvider(): array
    {
        return [
            ['id' => 1, 'start_time' => 1631232000, 'end_time' => 1631232000 + 86400, 'name' => 'Test'],
        ];
    }
}