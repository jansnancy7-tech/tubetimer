CREATE TABLE timers (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    youtube_url VARCHAR(2048) NOT NULL,

    trigger_time DATETIME NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);