#! /bin/sh

USERINFODIR=../user
USERTABLE_CSV_FILENAME=$USERINFODIR/usertable.csv

python dumpUser.py > $USERTABLE_CSV_FILENAME
