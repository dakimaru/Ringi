@ECHO OFF

cd %SCRIPTROOT%
call env_win.cmd

%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% budgets > %SQLPATH%\_budgets.sql
%MYSQLPATH%\mysql -u root              < %SQLPATH%\createdb.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME% < %SQLPATH%\_budgets.sql

%PYTHONROOT%\python readBudget.py %BUDGETROOT%\%BUDGET_XLS_FILENAME% > %BUDGETROOT%\%BUDGET_CSV_FILENAME%
%PYTHONROOT%\python loadBudget.py %BUDGETROOT%\%BUDGET_CSV_FILENAME% 2012
