select s.skater_id as id, r.division_id as did, 
	s.skater_first as firstname, s.skater_last as lastname, 
	r.heatnum as heat, r.min as min, r.sec as sec, r.hun as hun , 
	r.place as place, r.point as point, r.notes as notes ,
	sum(r.point) as tot, 
	(select division_name from divisions where division_id = 21)
from raw_results r , skaters s 
where s.skater_id = r.skater_id and 
	r.heatnum in (1,2,3,4) and 
	r.division_id in 
		(select division_id 
		from divisions 
		where race_id = 6) 
group by s.skater_id
order by did, id, tot desc
;

#select skater_first, skater_last , sum(point) tot
  #from  skaters, raw_results r
  #where skaters.skater_id = r.skater_id and
	#r.division_id = 21
  #group by r.skater_id
  #order by tot desc
#;


select s.skater_id as id, r.division_id as did, 
	s.skater_first as firstname, s.skater_last as lastname, 
	r.heatnum as heat, r.min as min, r.sec as sec, 
	r.hun as hun , r.place as place, r.point as point, 
	r.notes as notes 
	(select sum(point) 
	   from raw_results
           where skate_id = id and
	         division_id = did
	   group by skater_id)
from raw_results r , skaters s 
where s.skater_id = r.skater_id and 
	r.heatnum in (1,2,3,4) and 
	r.division_id in 
		(select division_id 
			from divisions 
			where race_id = 6) 
order by r.division_id , 
	s.skater_last, 
	s.skater_first, 
	r.heatnum;
