#! /bin/sh

USERINFODIR=../user
USERTABLE_CSV_FILENAME=$USERINFODIR/usertable.csv

python loadUser.py $USERTABLE_CSV_FILENAME
