CREATE TABLE IF NOT EXISTS ATTRIBUTES(
applicantid 
varchar(255) 
,
applydate 
date 
,
created_at 
datetime 
,
creator_id 
varchar(255) 
,
id 
int(10) 
primary key auto_increment  
not null  
,
ringstatus 
bool 
,
updated_at 
datetime 
,
updator_id 
varchar(255) 
) ENGINE=InnoDB;
