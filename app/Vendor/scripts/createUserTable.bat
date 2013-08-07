@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

%PYTHONROOT%\python loadUser.py %USERINFOPATH%\%USERTABLE_CSV_FILENAME%
cmd /c %SCRIPTROOT%\createLDAPTree.bat

