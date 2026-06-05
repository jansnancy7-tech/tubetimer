CREATE TABLE timers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    youtube_url VARCHAR(500) NOT NULL,
    trigger_time DATETIME NOT NULL,
    executed_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_timers_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);