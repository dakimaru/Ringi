#! /bin/sh
. env.sh

cd $SCRIPTROOT

#if [ "$#" -ne 1 ] || ! [ -f "$1" ]; then
#    echo "Usage: $0 <path to usertable.csv>" >&2
#    exit 1
#fi

slapadd -l $OPENLDAPSCHEMADIR/core.ldif 
ldapadd -c -h localhost -x -D "$LDAPADMINUSER" -w $LDAPADMINPASSWORD -f $USERINFOPATH/Customer.ldif
python convUsertableToLdif.py $USERINFOPATH/$USERTABLE_CSV_FILENAME > $USERINFOPATH/DeptAndPeople.ldif
ldapadd -c -h localhost -x -w $LDAPADMINPASSWORD -D "$LDAPADMINUSER" -f $USERINFOPATH/DeptAndPeople.ldif

