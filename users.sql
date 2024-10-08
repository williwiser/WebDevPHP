CREATE TABLE users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * FROM users;

ALTER TABLE users ADD COLUMN user_type ENUM('normal','editor') NOT NULL DEFAULT 'normal';
CREATE TABLE Newsletter(
	email varchar(255) NOT NULL,
    frequency varchar(255) NOT NULL,
    PRIMARY KEY (email)
);
