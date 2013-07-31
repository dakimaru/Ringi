@ECHO OFF

call env_win.cmd

%PYTHONROOT%\python loadUser.py %USERINFOPATH%\%USERTABLE_CSV_FILENAME%
%SCRIPTROOT%\createLDAPTree.bat

