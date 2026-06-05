<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('log_errors', '1');

ini_set(
    'error_log',
    __DIR__ . '/../logs/error.log'
);

if (!is_dir(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);

}