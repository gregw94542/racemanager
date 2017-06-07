update raw_results
  set distance=(
	select division_distance1 
	from divisions
	where 
	)
where distance is null 
      and heatnum = 1;
