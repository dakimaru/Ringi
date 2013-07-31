#! /bin/sh
. env.sh
if [ $# -ne 2 ]; then
    echo "Usage: $0 <DN> <newPassword>"
    exit 1
fi

ldappasswd -x -h localhost -D "$LDAPADMINUSER" -w $LDAPADMINPASSWORD -s $2 "$1"

