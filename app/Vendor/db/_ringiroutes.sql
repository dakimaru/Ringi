CREATE TABLE IF NOT EXISTS RINGIROUTES(
id 
int(10) 
primary key auto_increment  
not null  
,
ringino 
int(10) 
not null  
,
approverlayer 
int(3) 
not null  
,
approverid 
varchar(255) 
,
approvedate 
date 
,
ringistatus 
varchar(255) 
,
lastlayerflg 
bool 
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
ringino
,
approverlayer
)
) ENGINE=InnoDB;
