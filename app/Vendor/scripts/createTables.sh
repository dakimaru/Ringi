#! /bin/sh
. env.sh
cd $SCRIPTROOT
$MYSQLPATH/mysql -u root              < $SQLPATH/dropringidata.sql

./createRingiTables.sh
./createUserTable.sh
./createBudgetTables.sh
./createWorkflowTable.sh
./createMasterTable.sh

