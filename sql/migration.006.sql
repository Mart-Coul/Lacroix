ALTER TABLE production_lines ADD COLUMN team_leader_id INTEGER NULL;
ALTER TABLE production_lines ADD FOREIGN KEY fk_leader (team_leader_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE;
