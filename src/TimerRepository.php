<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class TimerRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->getConnection();
    }

    public function create(
        int $userId,
        string $youtubeUrl,
        string $triggerTime
    ): void {
        $statement = $this->connection->prepare(
            'INSERT INTO timers (
                user_id,
                youtube_url,
                trigger_time
            )
            VALUES (
                :user_id,
                :youtube_url,
                :trigger_time
            )'
        );

        $statement->execute([
            'user_id' => $userId,
            'youtube_url' => $youtubeUrl,
            'trigger_time' => $triggerTime
        ]);
    }

    public function findByUserId(
        int $userId
    ): array {
        $statement = $this->connection->prepare(
            'SELECT *
             FROM timers
             WHERE user_id = :user_id
             ORDER BY trigger_time ASC'
        );

        $statement->execute([
            'user_id' => $userId
        ]);

        return $statement->fetchAll();
    }

    public function delete(
        int $timerId,
        int $userId
    ): void {
        $statement = $this->connection->prepare(
            'DELETE FROM timers
             WHERE id = :id
             AND user_id = :user_id'
        );

        $statement->execute([
            'id' => $timerId,
            'user_id' => $userId
        ]);
    }
}