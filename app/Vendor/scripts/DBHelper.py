import mysql.connector
import datetime

DBHOST      = "localhost"
DBUSER      = "root"
DBPASSWORD  = ""
DBNAME      = "RINGIDATA"

IGNORE_AT_UPDATE = []
IGNORE_AT_INSERT = []

ADDITIONAL_ATTRS = {
    #'creator_id'    : 'LDAP',
}

ENUM_FIRST_VALUE = 100

def connect():
    cnx = mysql.connector.connect(user=DBUSER, database=DBNAME)

    return cnx

def getUpdateQuery(header, row, dbTable, keyColNames):
    #print header
    query = "UPDATE " + dbTable + " "
    query = query + "SET "
    first = True
    for i in range(len(header)):
        if header[i] in IGNORE_AT_UPDATE:
            continue

        if not first:
            query = query + ','
        first = False
        #print header[i], row
        query = query + header[i] + "=" + "\'"+str(row[header[i].lower()]) + "\' "

    query = query + "WHERE " 
    first = True
    for i in range(len(keyColNames)):
        if not first:
            query = query + " AND "
        first = False
        query = query + keyColNames[i] + " = \'" + str(row[keyColNames[i].lower()]) + "\'"

    return query
       

def getInsertQuery(dbTable, header, row):
    query = "INSERT INTO " + dbTable + " "
    query = query + "("
    first = True
    
    for col in header:
        #print col
        if not first:
            query = query + ","
        first = False
        query = query + col 
    query = query + ")"
    query = query + " VALUES ("
    first = True
    for colname in header:
        val = row[colname]
        #print val
        if not first:
            query = query + ","
        first = False
        query = query + "\'" + str(val) + "\'"
    query = query + ")"

    return query

def rowAlreadyExist(cursor, dbTable, header, row, keyColNames):
    dnFound = False

    for col in keyColNames:
        if not col in header:
            print col, " field not found!"
            return None

    query = "SELECT * "  
    #first = True
    #for col in keyColNames:
    #    if not first:
    #        query = query + ','
    #    first = False
    #    query = query + col
    query = query + " from " + dbTable
    query = query + " WHERE " 
    first = True
    for col in keyColNames:
        if not first:
            query = query + ' AND '
        first = False
        query = query + col + " = " + "\'" + str(row[col]) + "\'"

    #print row
    #print query

    cursor.execute(query)
    #print cursor.__dict__

    result = {}
    columns = tuple( [d[0].decode('utf8').encode('ascii','ignore') for d in cursor.description] )
    entryFound = False
    for r in cursor:
        result = dict(zip(columns, r))
        #entry found
        entryFound = True
    cursor.close()

    #print result, query

    if not entryFound:
        # suppressing this message as it's happening too often
        #print keyColNames, " not found"
        return None

    retval = []
    for col in keyColNames:
        retval.append(row[col])
    
    #print keyColNames , "=", retval, " found"

    return result

def updateRow(DBconn, dbTable, header, row, keyColNames): 
    query = ""
    cursor = DBconn.cursor()

    fetchedRow = rowAlreadyExist(cursor, dbTable, header, row, keyColNames)
    if fetchedRow:
        query = getUpdateQuery(header, fetchedRow, dbTable, keyColNames)
    else:
        #print "rows to insert = ", row
        query = getInsertQuery(dbTable, header, row)

    #print query

    cursor = DBconn.cursor(True)   
    cursor.execute(query)
    DBconn.commit()
    cursor.close()

def updateDB(dbTable,header,rows,keyColNames):
    DBconn = connect()

    header = header + ADDITIONAL_ATTRS.keys()
    for row in rows:
        #print "**** ENTERING ****"
        #print row
        row.update(ADDITIONAL_ATTRS)
        updateRow(DBconn, dbTable, header, row, keyColNames)

    DBconn.close() 

def updateRowIncremental(DBConn, dbTable, header, row, enumColName, keyColNames, incColName):
    query = ""
    cursor = DBConn.cursor()

    fetchedRow = rowAlreadyExist(cursor, dbTable, header, row, keyColNames)
    if fetchedRow:
        # should be identical, just overwrite it
        query = getUpdateQuery(header, fetchedRow, dbTable, keyColNames)
    else:
        # assign new value and insert
        cursor = DBConn.cursor(True)
        row[incColName] = getNextEnumValue(cursor, dbTable, enumColName, incColName, row)
        query = getInsertQuery(dbTable, header, row)

    #print query

    cursor = DBConn.cursor(True)
    cursor.execute(query)
    DBConn.commit()
    cursor.close()

def updateDBIncremental(dbTable, header, rows, enumColName, keyColNames, incColName):
    DBConn = connect()
    cursor = DBConn.cursor()
    query = None
    #for r in rows:
    #    print "rows to insert = ", r
    for row in rows:
        query = updateRowIncremental(DBConn, dbTable, header, row, enumColName, keyColNames, incColName)

    DBConn.close()

def getNextEnumValue(cursor, dbTable, enumColName, incColName, row):

    query = "select max(" + incColName + ") as maxvalue FROM "  \
            + dbTable + " WHERE "  \
            + enumColName + "=\'" + row[enumColName] + "\'"

    #print query
    cursor.execute(query)

    retval = str(ENUM_FIRST_VALUE)
    for dummy in cursor:
        #entry found
        if dummy[0]:
            #print dummy[0]
            retval = str(int(dummy[0])+1)

    cursor.close()

    #print "next enum val = ", retval
    return retval    
