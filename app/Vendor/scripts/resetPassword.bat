@ECHO OFF

cd %SCRIPTROOT%
call env_win.cmd

if "%~1"=="" goto ERROR
if "%~2"=="" goto ERROR

%OPENLDAPROOT%\ClientTools\ldappasswd -x -h localhost -D "%LDAPADMINUSER%" -w %LDAPADMINPASSWORD% -s '%~2' '%~1'
goto END

:ERROR
echo usage: resetpassword.bat "<DN>" "<new_password>"

:END
