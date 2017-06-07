show tables;
desc skaters;
desc renewal_dates;

select skater_first, skater_last, skater_renewaldate 
from skaters
where skater_renewaldate is not null
 and skater_renewaldate > date('2010-7-01')
 order by skater_renewaldate;
