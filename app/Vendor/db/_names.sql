CREATE TABLE IF NOT EXISTS NAMES(
activeflag 
bool 
not null  
,
created_at 
datetime 
,
creator_id 
varchar(255) 
,
ctlflg1 
bool 
,
ctlflg2 
bool 
,
ctlflg3 
bool 
,
ctlflg4 
bool 
,
ctlflg5 
bool 
,
deletereason 
text 
,
id 
int(10) 
primary key auto_increment  
not null  
,
name 
varchar(255) 
not null  
,
namecd 
varchar(255) 
not null  
,
nameeng 
varchar(255) 
,
nametype 
varchar(255) 
not null  
,
updated_at 
datetime 
,
updator_id 
varchar(255) 
) ENGINE=InnoDB;
