#! /bin/sh

#/usr/bin/python ./exportLdap.py >  ./directorydump.csv
#/Applications/XAMPP/xamppfiles/bin/mysql -u root ringidata < ./mysql.sql > ./output.log

/usr/bin/python ./loadLdap.py $USERINFOPATH/$USERTABLE_CSV_FILENAME $DEFAULT_USER_PASSWORD  > /dev/null
/usr/bin/python ./loadUser.py $USERINFOPATH/$USERTABLE_CSV_FILENAME  > /dev/null
