#! /bin/sh

MYSQLPATH=/Applications/XAMPP/xamppfiles/bin/
SQLPATH=../db

$MYSQLPATH/mysql -u root              < $SQLPATH/dropringidata.sql

./createRingiTables.sh
./createUserTable.sh
./createBudgetTables.sh
./createWorkflowTable.sh

