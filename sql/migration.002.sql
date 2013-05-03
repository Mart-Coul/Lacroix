CREATE TABLE products (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  target_productivity INTEGER NOT NULL
) ENGINE=InnoDB;

CREATE TABLE note_templates (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  content TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE rooms (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,

  UNIQUE KEY name (name)
) ENGINE=InnoDB;

CREATE TABLE production_lines (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  speed_adjustment NUMERIC(10, 2) NOT NULL,
  room_id INTEGER NOT NULL,
   
  UNIQUE KEY name (name)
) ENGINE=InnoDB;

ALTER TABLE production_lines ADD FOREIGN KEY fk_room (room_id) REFERENCES rooms (id) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE TABLE data_entries (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  production_line_id INTEGER NOT NULL,
  product_id INTEGER NOT NULL,

  created_at INTEGER NOT NULL,
  reading INTEGER NOT NULL,
  employees INTEGER NOT NULL,

  notes TEXT NULL
) ENGINE=InnoDB;

ALTER TABLE data_entries ADD FOREIGN KEY fk_production_line (production_line_id) REFERENCES production_lines (id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE data_entries ADD FOREIGN KEY fk_product (product_id) REFERENCES products (id) ON UPDATE CASCADE ON DELETE CASCADE;
