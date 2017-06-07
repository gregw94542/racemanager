drop table IF EXISTS raw_results;
create table raw_results (
	raw_id int auto_increment primary key,
	division_id int,
	skater_id int,
	heatnum int,
	min varchar(3),
	sec varchar(2),
	hun varchar(2),
	pos varchar(2),
	point varchar(2),
	notes varchar(100),
	place varchar(2)
);

