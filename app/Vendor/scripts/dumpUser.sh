#! /bin/sh
. env.sh
cd $SCRIPTROOT
python exportUser.py > $USERINFOPATH/$USERTABLE_CSV_FILENAME
