<?php

declare(strict_types=1);

require_once __DIR__ . '/UserRepository.php';

class Auth
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function register(
        string $email,
        string $password
    ): void {
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $this->users->create(
            $email,
            $passwordHash
        );
    }

    public function login(
        string $email,
        string $password
    ): bool {
        $user = $this->users->findByEmail(
            $email
        );

        if (!$user) {
            return false;
        }

        if (
            !password_verify(
                $password,
                $user['password_hash']
            )
        ) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        return isset(
            $_SESSION['user_id']
        );
    }
}