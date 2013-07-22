#! /bin/sh

# reset user password on LDAP server

LDAP_ADMIN=cn=Manager,dc=enspirea,dc=com
LDAP_ADMINPWD=820davis

if [ $# -ne 2 ]; then
    echo "Usage: $0 <DN> <newPassword>"
    exit 1
fi

ldappasswd -x -h localhost -D "$LDAP_ADMIN" -w $LDAP_ADMINPWD -s $2 "$1"

