#! /bin/sh

RINGIDBNAME=ringidata
MYSQLPATH=/Applications/XAMPP/xamppfiles/bin/
SCRIPTPATH=../scripts
SCHEMAPATH=../db/schema
SQLPATH=../db

python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH users 1 25          > $SQLPATH/_users.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH routes 1 20         > $SQLPATH/_routes.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH names 1 17          > $SQLPATH/_names.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH ringiroutes 1 12    > $SQLPATH/_ringiroutes.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH ringihistories 1 13 > $SQLPATH/_ringihistories.sql
python $SCRIPTPATH/convXlsSchemaToSql.py $SCHEMAPATH attributes 1 9      > $SQLPATH/_attributes.sql

$MYSQLPATH/mysql -u root              < $SQLPATH/createdb.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_users.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_routes.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_names.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_ringiroutes.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_ringihistories.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_attributes.sql

