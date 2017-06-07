select skater_id , division_id
 from division_skaters
 where division_id in ( 
	select  division_id from divisions where 
	race_id = 6)
;

select heatnum 
from raw_results
where skater_id = 11  and 
	division_id = 21;

drop procedure if exists foo
// 
create procedure foo (IN race_id INT, OUT div_id varchar(100))
begin
	declare xx varchar(100);
	declare cur1 cursor for select division_id from divisions where race_id = race_id;
	open cur1;
	fetch cur_1 into xx;
	close cur_1;
	
	set div_id = xx;
end;

set @x = 6;
call foo(@x,@y)
select @y

