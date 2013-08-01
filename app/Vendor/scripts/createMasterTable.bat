@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

%PYTHONROOT%\python %SCRIPTROOT%\loadMaster.py %SCHEMAPATH%\namesMST.xlsx


