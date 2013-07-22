CREATE TABLE IF NOT EXISTS USERS(
id 
int(10) 
primary key auto_increment  
not null  
,
usertype 
bool 
not null  
,
name 
varchar(255) 
,
username 
varchar(255) 
not null  
,
password 
varchar(255) 
not null  
,
mail 
varchar(255) 
,
department 
varchar(255) 
,
title 
varchar(255) 
,
dn 
varchar(255) 
,
manager 
varchar(255) 
,
companyemail 
varchar(255) 
,
mobileemail 
varchar(255) 
,
agentcd 
varchar(255) 
,
agentstrday 
date 
,
agentendday 
date 
,
companytel 
int(11) 
,
extention 
int(11) 
,
cellphone 
int(11) 
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
