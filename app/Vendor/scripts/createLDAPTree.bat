#ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

if "%~1"=="" goto ERROR

%OPENLDAPROOT%\slapadd -l %OPENLDAPSCHEMAPATH%\core.ldif 
%OPENLDAPROOT%\ClientTools\ldapmodify -c -a -h %1 -x -D "%LDAPADMINUSER%" -w %LDAPADMINPASSWORD% -f %USERINFOPATH%\Customer.ldif
%PYTHONROOT%\python convUsertableToLdif.py %USERINFOPATH%/%USERTABLE_CSV_FILENAME% > %USERINFOPATH%\DeptAndPeople.ldif
%OPENLDAPROOT%\ClientTools\ldapmodify -c -a -h %1 -x -w %LDAPADMINPASSWORD% -D "%LDAPADMINUSER%" -f %USERINFOPATH%\DeptAndPeople.ldif

goto END

:ERROR
echo usage: createLDAPTree.bat hostname

:END
