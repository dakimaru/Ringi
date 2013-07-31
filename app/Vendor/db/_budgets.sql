CREATE TABLE IF NOT EXISTS BUDGETS(
id 
int(10) 
primary key auto_increment  
not null  
,
year 
int(4) 
not null  
,
month 
int(2) 
not null  
,
department 
varchar(255) 
not null  
,
linecd 
varchar(255) 
not null  
,
project 
varchar(255) 
not null  
,
accountno 
varchar(255) 
not null  
,
source 
varchar(255) 
not null  
,
purpose 
varchar(255) 
not null  
,
budget 
int(11) 
not null  
,
benefit 
varchar(255) 
,
activeflag 
bool 
not null  
,
deletereason 
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
) ENGINE=InnoDB;
