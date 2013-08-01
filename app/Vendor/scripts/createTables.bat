ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

%MYSQLPATH%\mysql -u root              < %SQLPATH%\dropringidata.sql

cmd /c createRingiTables.bat
cmd /c createUserTable.bat
cmd /c createBudgetTables.bat
cmd /c createWorkflowTable.bat
cmd /c createMasterTable.bat

