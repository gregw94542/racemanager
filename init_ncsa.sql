drop table IF EXISTS races;
drop table IF EXISTS race;
create table races (
	race_id int auto_increment primary key,
	race_name varchar(50),
	race_location varchar(50),
	race_date	date,
	race_time	time
);

drop table IF EXISTS division;
drop table IF EXISTS divisions;
create table divisions (
	division_id int auto_increment primary key,
	division_name varchar(50),
	division_start_order int,
	division_distance1 int,
	division_distance2 int,
	division_distance3 int,
	division_distance4 int,
	division_distance5 int,
	division_distance6 int,
	race_id int
);

#
#
#drop table IF EXISTS skater;
#drop table IF EXISTS skaters;
#create table skaters (
#	skater_id int auto_increment primary key,
#	skater_first varchar(32),
#	skater_last varchar(32),
#	skater_dob date,
#	skater_email varchar(100),
#	skater_sex  varchar(1)
#);
#
drop table IF EXISTS raw_results;

create table raw_results (
	raw_id int auto_increment primary key,
	division_id int,
	skater_id int,
	heatnum int,
	min varchar(3),
	sec varchar(2),
	hun varchar(2),
	pos varchar(10),
	point varchar(2),
	notes varchar(100),
	total_points int,
	place varchar(2)



drop table IF EXISTS division_skaters;
create table division_skaters (
	division_skaters_id int auto_increment primary key,
	division_id int,
	race_id int,
	skater_id int
);


#insert into races
	#(race_name, race_location, race_date, race_time)
	#values
	#('State Champs', 'San Jose, Ca', STR_TO_DATE('10/11/2007', '%d/%m/%Y'), '10 am');
#
#insert into races
	#(race_name, race_location, race_date, race_time)
	#values
	#('National Champs', 'Cleveland, Oh', STR_TO_DATE('02/11/2007', '%d/%m/%Y'), '10 am');
#


