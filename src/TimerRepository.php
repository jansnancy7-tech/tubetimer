<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Logger.php';

class TimerRepository
{
    private PDO $connection;

    private Logger $logger;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->getConnection();

        $this->logger = new Logger();
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

        $this->logger->info(
            sprintf(
                'Timer created | user_id=%d | url=%s | trigger_time=%s',
                $userId,
                $youtubeUrl,
                $triggerTime
            )
        );
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

        $timers = $statement->fetchAll();

        $this->logger->info(
            sprintf(
                'Timers requested | user_id=%d | count=%d',
                $userId,
                count($timers)
            )
        );

        return $timers;
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

        $this->logger->info(
            sprintf(
                'Timer deleted | timer_id=%d | user_id=%d',
                $timerId,
                $userId
            )
        );
    }
}