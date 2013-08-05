#! /bin/sh
. env.sh

cd $SCRIPTROOT

if [ "$#" -ne 1 ] ; then
    echo "Usage: $0 <hostname>" >&2
    exit 1
fi

slapadd -l $OPENLDAPSCHEMADIR/core.ldif
ldapadd -c -h $1 -x -D "$LDAPADMINUSER" -w $LDAPADMINPASSWORD -f $USERINFOPATH/Customer.ldif
python convUsertableToLdif.py $USERINFOPATH/$USERTABLE_CSV_FILENAME > $USERINFOPATH/DeptAndPeople.ldif
ldapadd -c -h $1 -x -w $LDAPADMINPASSWORD -D "$LDAPADMINUSER" -f $USERINFOPATH/DeptAndPeople.ldif

