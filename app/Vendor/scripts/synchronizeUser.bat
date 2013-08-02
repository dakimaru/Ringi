@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

cmd /c dumpUser.bat
cmd /c createLDAPTree.bat
