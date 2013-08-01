@ECHO OFF

call env_win.cmd
cd %SCRIPTROOT%

%MYSQLPATH%\mysql -u root                <  %SQLPATH%\dropringidata.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% users           > %SQLPATH%\_users.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% routes          > %SQLPATH%\_routes.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% names           > %SQLPATH%\_names.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% ringiroutes     > %SQLPATH%\_ringiroutes.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% ringihistories  > %SQLPATH%\_ringihistories.sql
%PYTHONROOT%\python %SCRIPTROOT%\convXlsSchemaToSql.py %SCHEMAPATH% attributes      > %SQLPATH%\_attributes.sql

%MYSQLPATH%\mysql -u root                <  %SQLPATH%\createdb.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_users.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_routes.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_names.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_ringiroutes.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_ringihistories.sql
%MYSQLPATH%\mysql -u root %RINGIDBNAME%  <  %SQLPATH%\_attributes.sql

