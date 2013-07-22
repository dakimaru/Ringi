#! /bin/sh

USERTABLE_CSV_FILENAME=../user/usertable.csv
DEFAULT_PASSWORD=root

#/usr/bin/python ./exportLdap.py >  ./directorydump.csv
#/Applications/XAMPP/xamppfiles/bin/mysql -u root ringidata < ./mysql.sql > ./output.log

/usr/bin/python ./loadLdap.py $USERTABLE_CSV_FILENAME $DEFAULT_PASSWORD
/usr/bin/python ./loadUser.py $USERTABLE_CSV_FILENAME
