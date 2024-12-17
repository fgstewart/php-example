-- 02-seed-data.sql
INSERT INTO users (username, email) VALUES 
('johndoe', 'john@example.com'),
('janedoe', 'jane@example.com');

INSERT INTO posts (user_id, title, content) VALUES 
(1, 'First Post', 'This is my first blog post'),
(2, 'Hello World', 'Welcome to my website');