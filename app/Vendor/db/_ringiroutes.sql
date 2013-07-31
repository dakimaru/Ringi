CREATE TABLE IF NOT EXISTS RINGIROUTES(
id 
int(10) 
primary key auto_increment  
not null  
,
ringino 
varchar(255) 
not null  
,
approverlayer 
bool 
not null  
,
approverid 
varchar(255) 
,
approvedate 
date 
,
ringstatus 
bool 
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
ringiNo
,
approverLayer
)
) ENGINE=InnoDB;
