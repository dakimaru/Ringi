#! /bin/sh

./createTable.sh

# change permission of a certain folder
cd ../..
chmod -R a+w Vendor/user
chmod -R a+w Vendor/ldap
