import mysql.connector
import csv
import datetime
import sys

DBHOST      = "localhost"
DBUSER      = "root"
DBPASSWORD  = ""
DBNAME      = "RINGIDATA"
DBTABLE     = "USERS"

IGNORE_AT_INSERT = ['password']
IGNORE_AT_UPDATE = ['password']

ADDITIONAL_ATTRS = {
    'created_at'     : datetime.datetime.today().isoformat(),
    'usertype'      : '0',
    'activeflag'    : '1',
    'creator_id'    : 'LDAP',
}

#cnx = mysql.connector.connect(user=DBUSER, database=DBNAME)
#cursor = cnx.cursor()

def connect():
    cnx = mysql.connector.connect(user=DBUSER, database=DBNAME)

    return cnx

def getUpdateQuery(header, row, DN):
    print header
    query = "UPDATE " + DBTABLE + " "
    query = query + "SET "
    first = True
    for i in range(len(header)):
        if header[i] in IGNORE_AT_UPDATE:
            continue

        if not first:
            query = query + ','
        first = False
        query = query + header[i] + "=" + "\'"+row[header[i]] + "\' "

    query = query + "WHERE DN = \'" + DN + "\'"

    return query
       

def getInsertQuery(header, row):
    query = "INSERT INTO " + DBTABLE + " "
    query = query + "("
    first = True
    
    for col in header:
        if not first:
            query = query + ","
        first = False
        query = query + col 
    query = query + ")"
    query = query + " VALUES ("
    first = True
    for colname in header:
        val = row[colname]
        if colname == 'password':
            val = ''
        if not first:
            query = query + ","
        first = False
        query = query + "\'" + val + "\'"
    query = query + ")"

    return query

def DNExist(cursor, header, row):
    dnFound = False

    for h in header:
        if h == "DN":
            dnFound = True
            break

    if not dnFound:
        print "DN field not found!"
        return False

    query = "SELECT DN from " + DBTABLE
    query = query + " WHERE DN = " + "\'" + row['DN'] + "\'"
    #query = query + " WHERE DN = " + "\'" + "hoge" + "\'"

    cursor.execute(query)
    #print cursor.__dict__
    entryFound = False
    for (DN) in cursor:
        #entry found
        entryFound = True
    cursor.close()

    print query

    if not entryFound: 
        print "DN " + row['DN'] + " not found"
        return None

    print "DN " + row['DN'] + " found"

    return row['DN']

def updateRow(DBconn, header, row): 
    query = ""
    cursor = DBconn.cursor()

    DN = DNExist(cursor, header, row)
    if DN:
        query = getUpdateQuery(header,row, DN)
    else:
        query = getInsertQuery(header,row)

    print query

    cursor = DBconn.cursor(True)   
    cursor.execute(query)
    DBconn.commit()
    cursor.close()

def updateDB(header,rows):
    DBconn = connect()

    header = header + ADDITIONAL_ATTRS.keys()
    for row in rows:
        print "**** ENTERING ****"
        print row
        row.update(ADDITIONAL_ATTRS)
        updateRow(DBconn, header, row)

    DBconn.close() 

def convertToMap(columns, row):
    map = {}
    for i in range(len(columns)):
        key = columns[i]
        val = row[i]
        map[key] = val
    
    print map    
    return map

def readCsv(csvfilename):
    columns = []
    rows    = []
    with open(csvfilename, 'rb') as csvfile:
        csvreader = csv.reader(csvfile, delimiter=',', quotechar='"')
        lineno = 0
        for row in csvreader:
            lineno = lineno + 1
            if lineno == 1:
                # list of column header
                columns = row
                continue

            map = convertToMap(columns,row)
            rows.append(map)

            lineno = lineno + 1

    return (columns,rows)

def doit(csvfilename):
    header, rows = readCsv(csvfilename)
    connect = updateDB(header, rows)

def usage():
    print "usage: ", sys.argv[0], "<usertable.csv>"
    exit()

if len(sys.argv) != 2:
    usage()
    exit()

csvfilename   = sys.argv[1]

doit(csvfilename) 
