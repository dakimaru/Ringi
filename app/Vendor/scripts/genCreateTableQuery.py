from xlrd import open_workbook
import string
import sys

QUERY_HEAD      = "CREATE TABLE IF NOT EXISTS "
QUERY_OPTION    = ") ENGINE=InnoDB;"

COL_NAME =0
COL_TYPE =2
COL_PRI  =3
COL_NULL =4
COL_UNIQ =5
COL_BIGGEST =5

COL_TOREAD = [COL_NAME, COL_TYPE, COL_PRI, COL_NULL, COL_UNIQ]

ROW_START =1
ROW_END   =19

DECLARATIVE_STR = {
    COL_PRI  : "PRIMARY KEY auto_increment",
    COL_NULL : "NOT NULL",
    COL_UNIQ : "UNIQUE",
}

def genDeclarativeStr(colIndex,value):
    retval = ""
    #print type(value)
    if isinstance(value,str) or isinstance(value,unicode):
        #print "==>value is string"
        value = value.strip()
        if len(value.strip()) == 0:
            return  ""
        
    if colIndex in DECLARATIVE_STR:
        #print "declarative var found= '", value , "'"
        retval = DECLARATIVE_STR[colIndex]
   
    return retval + ' '
 

def genQuerySnip(colIndex,value):
    retval = ''
    if colIndex == COL_NAME:
        retval = value;
    elif colIndex == COL_TYPE:
        if colIndex == COL_TYPE and value == "tinyint(1)":
            retval = "bool"
        else:
            retval = value;
    else:
        retval = genDeclarativeStr(colIndex,value)

    return (retval + ' ').lower()

        
def readXls(pathToExcel,tablename,rowFrom,rowTo):
    filename = tablename + ".xlsx"
    filename = pathToExcel + "/" + filename 
    wb = open_workbook(filename)
    data = []

    print QUERY_HEAD + tablename + '('
    for s in wb.sheets():
        #print 'Sheet:',s.name
        first = True
        for row in range(rowFrom,rowTo):
            if not first:
                print ","
            first = False
            for col in range(0, COL_BIGGEST+1):
                if col in COL_TOREAD:
                    val = s.cell(row,col).value
                    #print col, val.value
                    val = genQuerySnip(col,val)
                    if val.strip() != "":
                        print val
            
    print QUERY_OPTION

def doit(pathToExcel, tablename, rowFrom, rowTo):
    dArray = readXls(pathToExcel, tablename, rowFrom, rowTo)

def usage():
    print "usage: ", sys.argv[0], "<tablename> <rowFrom> <rowTo>"
    exit()

if len(sys.argv) != 5:
    usage()
    exit()

pathToExcel = sys.argv[1].upper()
tablename   = sys.argv[2].upper()
rowFrom     = int(sys.argv[3])
rowTo       = int(sys.argv[4])
 
doit( pathToExcel, tablename, rowFrom, rowTo )

