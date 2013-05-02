INSERT INTO people (first_name, last_name) VALUES ('Konstantin', 'Burnaev');

INSERT INTO users (email, salt, password, person_id) VALUES 
  ('kbourn@gmail.com', 'dynamic_salt', MD5(CONCAT('password', '78r9esr789fd', 'dynamic_salt')), NULL),
  ('bkon@bkon.ru', 'alt-salt', MD5(CONCAT('password', '78r9esr789fd', 'alt-salt')), 1);

INSERT INTO user_roles (user_id, role) VALUES (1, 'admin');
