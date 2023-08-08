<?php

declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Schedule;

use Tymeshift\PhpTest\Components\DatabaseInterface;
use Tymeshift\PhpTest\Domains\Schedule\Interfaces\ScheduleStorageInterface;

class ScheduleStorage implements ScheduleStorageInterface
{
    /**
     * @var DatabaseInterface
     */
    private DatabaseInterface $db;

    /**
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): array
    {
        return $this->db->query('SELECT * FROM schedules WHERE id=:id', ["id" => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): array
    {
        return $this->db->query('SELECT * FROM schedules WHERE id in (:ids)', $ids);
    }
}