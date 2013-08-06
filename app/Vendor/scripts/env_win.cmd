REM third party location
set MYSQLPATH=C:\xampp\mysql\bin
set PYTHONROOT=C:\python27
IF EXIST "C:\Program Files (x86)\Python27\python.exe". (
	set PYTHONROOT="C:\Program Files (x86)\Python27"
)
set OPENLDAPROOT=C:\OpenLDAP

REM ringi configuration
set VENDORROOT=C:\xampp\htdocs\ringi\app\vendor
set SCRIPTROOT=%VENDORROOT%\scripts
set BUDGETROOT=%VENDORROOT%\budget
set SCHEMAPATH=%VENDORROOT%\db\schema
set USERINFOPATH=%VENDORROOT%\user
set SQLPATH=%VENDORROOT%\db
set OPENLDAPSCHEMAPATH=%VENDORROOT%\ldap\schema

REM data source file names
set BUDGET_CSV_FILENAME=budget.csv
set BUDGET_XLS_FILENAME=FAB2012.xlsx
set USERTABLE_CSV_FILENAME=usertable.csv
set ATTACHMENT_FILENAME=attachment.zip

REM default system account and passwords
set DEFAULT_USER_PASSWORD=root
set LDAPADMINPASSWORD=820davis
set LDAPADMINUSER=cn=Manager,dc=enspirea,dc=com

REM db configuration
set RINGIDBNAME=ringidata

REM workflow configuration
set WORKFLOW_OPTION=dept
