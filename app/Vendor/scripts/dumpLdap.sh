#! /bin/sh

if [ "$#" -ne 1 ] ; then
    echo "Usage: $0 <ldap_server_in_ldapinfo.ini>" >&2
    exit 1
fi

python exportLdap.py $1
