CREATE TABLE IF NOT EXISTS ROUTES(
id 
int(10) 
primary key auto_increment  
not null  
,
approveroutetype 
bool 
not null  
,
person 
varchar(255) 
,
department 
varchar(255) 
not null  
,
moneycondition 
int(11) 
,
ratecondition 
int(11) 
,
conditionflg 
bool 
,
approverlayer 
int(5) 
not null  
,
approverdept 
varchar(255) 
not null  
,
approvertitle 
varchar(255) 
not null  
,
approverid 
varchar(255) 
,
agentflg 
bool 
,
jumgflg 
bool 
,
activeflag 
bool 
not null  
,
deletereason 
varchar(255) 
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
) ENGINE=InnoDB;
