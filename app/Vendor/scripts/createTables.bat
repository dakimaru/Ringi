@ECHO OFF

call env_win.cmd

cd %SCRIPTROOT%
%MYSQLPATH%\mysql -u root              < %SQLPATH%\dropringidata.sql

createRingiTables.bat
createUserTable.bat
createBudgetTables.bat
createWorkflowTable.bat
createMasterTable.bat

