#! /bin/sh

RINGIDBNAME=ringidata
MYSQLPATH=/Applications/XAMPP/xamppfiles/bin/
SCRIPTPATH=../scripts
#SCHEMAPATH=../db/schema
SCHEMAPATH=/Volumes/Public/Ringi_Share/RingiTables
SQLPATH=../db

python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH users           > $SQLPATH/_users.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH routes          > $SQLPATH/_routes.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH names           > $SQLPATH/_names.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH ringiroutes     > $SQLPATH/_ringiroutes.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH ringihistories  > $SQLPATH/_ringihistories.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH attributes      > $SQLPATH/_attributes.sql

$MYSQLPATH/mysql -u root              < $SQLPATH/createdb.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_users.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_routes.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_names.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_ringiroutes.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_ringihistories.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_attributes.sql

