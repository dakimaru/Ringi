ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

if "%~1"=="" goto ERROR
if "%~2"=="" goto ERROR
if "%~3"=="" goto ERROR

%OPENLDAPROOT%\ClientTools\ldappasswd -x -h %~1 -D "%LDAPADMINUSER%" -w %LDAPADMINPASSWORD% -s "%~3" "%~2"
goto END

:ERROR
echo usage: resetpassword.bat hostname "<DN>" "<new_password>"

:END
