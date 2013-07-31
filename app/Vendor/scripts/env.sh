#! /bin/sh

### third party location
OPENLDAPSCHEMADIR=/etc/openldap/schema
MYSQLPATH=/Applications/XAMPP/xamppfiles/bin/

### ringi configuration
SCRIPTROOT=../scripts
BUDGETROOT=../budget
SCHEMAPATH=../db/schema
USERINFOPATH=../user
SQLPATH=../db

### data source file names
BUDGET_CSV_FILENAME=budget.csv
BUDGET_XLS_FILENAME=FAB2012.xlsx
USERTABLE_CSV_FILENAME=usertable.csv

### default system account and passwords
DEFAULT_USER_PASSWORD=root
LDAPADMINPASSWORD=820davis
LDAPADMINUSER=cn=Manager,dc=enspirea,dc=com

### db configuration
RINGIDBNAME=ringidata

### workflow configuration
WORKFLOW_OPTION=dept
