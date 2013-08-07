#@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

if "%~1"=="" goto ERROR

cmd /c dumpUser.bat
cmd /c createLDAPTree.bat %1

goto END

:ERROR
echo usage: synchronizeUser.bat hostname

:END
