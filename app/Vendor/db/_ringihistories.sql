CREATE TABLE IF NOT EXISTS RINGIHISTORIES(
id 
int(10) 
primary key auto_increment  
not null  
,
ringino 
varchar(255) 
not null  
,
ringiseq 
bool 
not null  
,
processerid 
varchar(255) 
not null  
,
processdate 
date 
not null  
,
approverlayer 
bool 
not null  
,
ringiaction 
varchar(255) 
not null  
,
comment 
text 
,
creator_id 
varchar(255) 
,
created_at 
datetime 
,
updator_id 
varchar(255) 
,
updated_at 
datetime 
,UNIQUE KEY compUniqDummy (
ringiNo
,
ringiseq
)
) ENGINE=InnoDB;
