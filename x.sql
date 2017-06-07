select distance, min, sec, hun , race_enable, races.race_id, race_name, race_date, bogusity 
from raw_results, divisions, races 
where skater_id = "14" 
	and distance = "1500" 
	and raw_results.division_id = divisions.division_id 
	and divisions.race_id = races.race_id 
	and ( (hun != 0) or (sec != 0) or (min != 0)) 
	and race_date < ("2013-01-19") 
	and race_enable = 1 
	and bogusity = 0 
order by min, sec, hun limit 2 
