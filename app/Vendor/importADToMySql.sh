#! /bin/sh

#/usr/bin/python ./exportLdap.py >  ./directorydump.csv
#/Applications/XAMPP/xamppfiles/bin/mysql -u root ringidata < ./mysql.sql > ./output.log

/usr/bin/python ./importLdap.py 
/usr/bin/python ./loadUser.py 
