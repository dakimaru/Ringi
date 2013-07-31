from xlrd import open_workbook
import string
import sys
import DBHelper

COL_NAMETYPE = 0
COL_NAMECD   = 1
COL_NAME     = 2
COL_NAMEENG  = 3

ID_DBNAME_MAP = {
    COL_NAMETYPE: "nametype",
    COL_NAMECD  : "namecd",
    COL_NAME    : "name",
    COL_NAMEENG : "nameeng",
} 

COL_TOREAD = [COL_NAMETYPE, COL_NAMECD, COL_NAME, COL_NAMEENG]
DBTABLE_MASTER = "names"

def readXls(filename,tablename,rowFrom=1):
    wb = open_workbook(filename)
    rowsToSave = []

    for s in wb.sheets():
        #print 'Sheet:',s.name
        first = True
        for row in range(rowFrom,s.nrows):
            nameToAdd = {}
            first = False
            for col in COL_TOREAD:
                val = s.cell(row,col).value
                #print col, val.value
                nameToAdd[ID_DBNAME_MAP[col]] = val
            rowsToSave.append(nameToAdd)

    return rowsToSave

def doit(pathToExcel, tablename):
    #print 'reading table:', tablename
    rows = readXls(pathToExcel, tablename)

    header = ID_DBNAME_MAP.values() 
    keyColNames = ID_DBNAME_MAP.values() 
    DBHelper.updateDB(tablename,header,rows,keyColNames)

def usage():
    print "usage: ", sys.argv[0], "<Master_Table_Def.xlsx>"
    exit()

if len(sys.argv) != 2:
    usage()
    exit()

pathToExcel = sys.argv[1]
 
doit( pathToExcel, DBTABLE_MASTER)

