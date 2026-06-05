<?php

declare(strict_types=1);

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $env['DB_HOST'],
            $env['DB_PORT'],
            $env['DB_NAME']
        );

        $this->connection = new PDO(
            $dsn,
            $env['DB_USER'],
            $env['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
