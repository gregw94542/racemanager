show tables;
desc races;
desc divisions;
select * from races;
select * from divisions;

select skater_first, skater_last
  from skaters
  where skater_id in
	(select skater_id 
	  from division_skaters
	  where division_id = '1')
   order by skater_last, skater_first;
	  
