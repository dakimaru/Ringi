#! /bin/sh

$MYSQLPATH/mysql -u root              < $SQLPATH/dropringidata.sql

./createRingiTables.sh
./createUserTable.sh
./createBudgetTables.sh
./createWorkflowTable.sh

