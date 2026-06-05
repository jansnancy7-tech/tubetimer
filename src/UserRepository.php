<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class UserRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->getConnection();
    }

    public function create(
        string $email,
        string $passwordHash
    ): void {
        $statement = $this->connection->prepare(
            'INSERT INTO users (
                email,
                password_hash
            )
            VALUES (
                :email,
                :password_hash
            )'
        );

        $statement->execute([
            'email' => $email,
            'password_hash' => $passwordHash
        ]);
    }

    public function findByEmail(
        string $email
    ): ?array {
        $statement = $this->connection->prepare(
            'SELECT *
             FROM users
             WHERE email = :email'
        );

        $statement->execute([
            'email' => $email
        ]);

        $user = $statement->fetch();

        return $user ?: null;
    }
}