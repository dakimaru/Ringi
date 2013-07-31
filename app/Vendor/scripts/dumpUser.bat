@ECHO OFF

cd %SCRIPTROOT%
call env_win.cmd

%PYTHONROOT%\python exportUser.py > %USERINFOPATH%\%USERTABLE_CSV_FILENAME%
