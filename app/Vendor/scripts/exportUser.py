import sys
import CSVHelper
import DBHelper

USER_CSV_DN             = "DN"
USER_CSV_USERNAME       = "username"
USER_CSV_TITLE          = "title"
USER_CSV_MAIL           = "mail"
USER_CSV_DEPARTMENT     = "department"
USER_CSV_NAME           = "name"
USER_CSV_MANAGER        = "manager"

USERS_TABLENAME       = "USERS"
USERS_COLUMNS         = [
                        USER_CSV_DN,
                        USER_CSV_USERNAME,
                        USER_CSV_TITLE,
                        USER_CSV_MAIL,
                        USER_CSV_DEPARTMENT,
                        USER_CSV_NAME,
                        USER_CSV_MANAGER,
                        ]

def doit(tablename, columns):
    rows = DBHelper.queryTable(tablename, columns)

    CSVHelper.printRows(columns,rows)

def usage():
    print "usage: ", sys.argv[0], ""
    exit()

if len(sys.argv) != 1:
    usage()
    exit()

doit(USERS_TABLENAME, USERS_COLUMNS)

