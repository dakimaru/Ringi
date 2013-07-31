#! /bin/sh

cd $SCRIPTROOT

python $SCRIPTROOT/convXlsSchemaToSql.py $SCHEMAPATH budgets > $SQLPATH/_budgets.sql
$MYSQLPATH/mysql -u root              < $SQLPATH/createdb.sql
$MYSQLPATH/mysql -u root $RINGIDBNAME < $SQLPATH/_budgets.sql

python readBudget.py $BUDGETROOT/$BUDGET_XLS_FILENAME > $BUDGETROOT/$BUDGET_CSV_FILENAME
python loadBudget.py $BUDGETROOT/$BUDGET_CSV_FILENAME 2012
