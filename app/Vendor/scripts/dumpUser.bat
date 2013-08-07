#@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

%PYTHONROOT%\python exportUser.py > %USERINFOPATH%\%USERTABLE_CSV_FILENAME%
