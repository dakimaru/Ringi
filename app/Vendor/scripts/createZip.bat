@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

cd $1
IF EXIST $2\%ATTACHMENT_FILENAME%. (
    del $2\%ATTACHMENT_FILENAME%.
)

CScript zip.vbs $1 $2\%ATTACHMENT_FILENAME%



