ALTER TABLE  `data_entries` ADD  `team_leader_id` VARCHAR( 50 ) NULL;

CREATE TABLE `team_leaders` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(150) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

ALTER TABLE  `data_entries` CHANGE  `team_leader_id`  `team_leader_id` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE  `data_entries` ADD INDEX (  `team_leader_id` );

ALTER TABLE  `data_entries` DROP FOREIGN KEY  `data_entries_ibfk_1` ,
ADD FOREIGN KEY (  `production_line_id` ) REFERENCES  `lacroix`.`production_lines` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;

ALTER TABLE  `data_entries` DROP FOREIGN KEY  `data_entries_ibfk_2` ,
ADD FOREIGN KEY (  `product_id` ) REFERENCES  `lacroix`.`products` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;

ALTER TABLE  `data_entries` ADD FOREIGN KEY (  `team_leader_id` ) REFERENCES  `lacroix`.`team_leaders` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;