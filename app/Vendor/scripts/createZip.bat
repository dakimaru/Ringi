#ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

IF EXIST %1\%ATTACHMENT_FILENAME%. (
    del %1\%ATTACHMENT_FILENAME%.
)

set TMPATTACHMENTFILENAME=%TEMP%\%time:~0,2%_%time:~3,2%_%time:~6,2%_%time:~9,2%_%ATTACHMENT_FILENAME%
CScript zip.vbs %1 %TMPATTACHMENTFILENAME%
copy %TMPATTACHMENTFILENAME% %1\%ATTACHMENT_FILENAME%

