#! /bin/sh

#if [ "$#" -ne 1 ] || ! [ -f "$1" ]; then
#    echo "Usage: $0 <path to usertable.csv>" >&2
#    exit 1
#fi

slapadd -l $OPENLDAPSCHEMADIR/core.ldif 
ldapadd -h localhost -x -D "$LDAPADMINUSER" -w $LDAPADMINPASSWORD -f $USERINFODIR/Customer.ldif
python convUsertableToLdif.py $USERINFOPATH/$USERTABLE_CSV_FILENAME > $USERINFODIR/DeptAndPeople.ldif
ldapadd -h localhost -x -w $LDAPADMINPASSWORD -D "$LDAPADMINUSER" -f $USERINFODIR/DeptAndPeople.ldif

