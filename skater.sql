sc raw_results;
desc skaters;
desc divisions;
desc races;



select rr.skater_id, r.race_enable, s.skater_first, s.skater_last, 
	rr.min, rr.sec, rr.hun ,
	r.race_name
  from raw_results rr, 
	skaters s, divisions d,
	races r
  where 
	s.skater_id = rr.skater_id and
	rr.division_id = d.division_id and
	d.race_id = r.race_id and
	r.race_enable <> '0'  and
	s.skater_first = 'John' and
	(heatnum = 1 and 
        d.division_id in  (select division_id from divisions
		where division_distance1 = '500'))  ;

select rr.skater_id, r.race_enable, s.skater_first, s.skater_last, 
	rr.min, rr.sec, rr.hun ,
	r.race_name
  from raw_results rr, 
	skaters s, divisions d,
	races r
  where 
	s.skater_id = rr.skater_id and
	rr.division_id = d.division_id and
	d.race_id = r.race_id and
	r.race_enable <> '0'  and
	s.skater_first = 'John' and
	(heatnum = 2 and 
        d.division_id in  (select division_id from divisions
		where division_distance2 = '500'))  ;

select rr.skater_id, r.race_enable, s.skater_first, s.skater_last, 
	rr.min, rr.sec, rr.hun ,
	r.race_name
  from raw_results rr, 
	skaters s, divisions d,
	races r
  where 
	s.skater_id = rr.skater_id and
	rr.division_id = d.division_id and
	d.race_id = r.race_id and
	r.race_enable <> '0'  and
	s.skater_first = 'John' and
	(heatnum = 3 and 
        d.division_id in  (select division_id from divisions
		where division_distance3 = '500'))  ;

select rr.skater_id, r.race_enable, s.skater_first, s.skater_last, 
	rr.min, rr.sec, rr.hun ,
	r.race_name, r.race_date
  from raw_results rr, 
	skaters s, divisions d,
	races r
  where 
	s.skater_id = rr.skater_id and
	rr.division_id = d.division_id and
	d.race_id = r.race_id and
	r.race_enable <> '0'  and
	s.skater_first = 'John' and
	(heatnum = 4 and 
        d.division_id in  (select division_id from divisions
		where division_distance4 = '500'))  ;

