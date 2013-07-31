#! /bin/sh

python loadUser.py $USERINFOPATH/$USERTABLE_CSV_FILENAME
./createLDAPTree.sh

