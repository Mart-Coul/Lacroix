INSERT INTO rooms (name) VALUES 
  ('1'),
  ('2'),
  ('3')
;

INSERT INTO production_lines (name, speed_adjustment, room_id) VALUES 
  ('1', 10, 1),
  ('2', 13.5, 1),
  ('3', 15, 1),
  ('4', 15, 2),
  ('5', 15, 2),
  ('6', 15, 3),
  ('7', 15, 3),
  ('8', 15, 3)
;

INSERT INTO products (name, target_productivity) VALUES 
  ('Beef', 100),
  ('Chicken', 125),
  ('Pork', 122)
;

INSERT INTO note_templates (content) VALUES 
  ('Training'),
  ('Special order')
;

INSERT INTO data_entries (production_line_id, product_id, created_at, reading, employees, notes) VALUES
  (1, 1, UNIX_TIMESTAMP(), 13, 9, 'Training'),
  (2, 1, UNIX_TIMESTAMP(), 14, 9, 'Special'),
  (2, 1, UNIX_TIMESTAMP(), 16, 10, NULL)
;
