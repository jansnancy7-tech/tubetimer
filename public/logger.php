<?php

declare(strict_types=1);

class Logger
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../logs/app.log';
    }

    public function info(string $message): void
    {
        $this->write('INFO', $message);
    }

    public function error(string $message): void
    {
        $this->write('ERROR', $message);
    }

    private function write(
        string $level,
        string $message
    ): void {
        file_put_contents(
            $this->file,
            sprintf(
                "[%s] [%s] %s\n",
                date('Y-m-d H:i:s'),
                $level,
                $message
            ),
            FILE_APPEND
        );
    }
}