set TMPUNZIPPATH=%TEMP%
set ZIPFILEPATH=%CD%
set DEPLOYPATH=%CD%\..\app\Vendor\excel

rmdir /S /Q %DEPLOYPATH%
CScript unzip.vbs %TMPUNZIPPATH% %ZIPFILEPATH%\PHPExcel_1.7.9_doc.zip
move %TMPUNZIPPATH%\Classes %DEPLOYPATH%
