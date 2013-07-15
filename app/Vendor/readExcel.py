from xlrd import open_workbook
import string

FILE_NAME = "FAB2012.xlsx"
BEGIN_LINE = 8
END_LINE   = 172
BEGIN_COL  = 1
END_COL    = 22
Column_Info = {
    1: "No",                    # B
    2: "Dept_Code",             # C
    3: "Line_Code",             # D
    4: "Project",               # E
    5: "Account_Code",          # F
    6: "Description",           # G
    7: "Source_USA_or_Japan",   # H
    8: "Purpose",               # I

    9: "April",                 # J
    10: "May",                  # K 
    11: "June",                 # L
    12: "July",                 # M
    13: "Aug",                  # N
    14: "Sep",                  # O
    15: "Oct",                  # P
    16: "Nov",                  # Q
    17: "Dec",                  # R
    18: "Jan",                  # S
    19: "Feb",                  # T
    20: "Mar",                  # U
    21: "Total",                # V

    22: "Benefit",              # W
}
Additional_Columns = {
    "year"  : 2012,
}

DB_Columns = [
    "No",       
    "Dept_Code",
    "Line_Code", 
    "Project",  
    "Account_Code",
    "Description", 
    "Source_USA_or_Japan", 
    "Purpose",        

    "year"

    "April",         
    "May",         
    "June",       
    "July",      
    "Aug",      
    "Sep",     
    "Oct",    
    "Nov",   
    "Dec",  
    "Jan", 
    "Feb",       
    "Mar",      
    "Total",   

    "Benefit",    
]

def readXls(filename):
    wb = open_workbook(filename)
    data = []

    for s in wb.sheets():
        #print 'Sheet:',s.name
        map = {}
        for row in range(BEGIN_LINE-1, END_LINE):
            map = {}
            for col in range(BEGIN_COL, END_COL):
                #print col,row,'=',s.cell(row,col)
                map[Column_Info[col]] = s.cell(row,col)
            map.update(Additional_Columns)
            data.append(map)
 
    return data

def getMapValue(map,key):
    retval = ''

    try:
        retval = map[key]
    except:
        pass

    #retval = "".join(retval.value)
    try:
        retval = str(retval.value)
    except:
        retval = ''

    return retval

def parseData(dCache, dMap):
    retval = ''

    first = True
    for key in DB_Columns:
        if not first:
            retval = retval + ","
        first = False
        mapValue= getMapValue(dMap,key)
        retval = retval + '\"' + mapValue + "\""

        if key in dMap.keys():
            dCache[dMap[key]] = mapValue

    return retval

def genCsvForMySqlImport(dCache):
    line = ""
    keys = dCache.keys()
    keys.sort()
    #print keys

    first = True
    for col in keys:
        if not first:
            line = line + ","
        first = False
        colval = ""
        try:
            colval = dCache[db_map[col]]
        except:
            pass
        line = line + "\"" + colval + "\""

    print line

def saveCsv(dArray):
    # header title
    line = ""
    first = True
    for c in DB_Columns:
        if not first:
            line = line + ","
        first = False
        line = line + "\'" + c + "\'"
    print line

    # data
    #print dArray
    for dMap in dArray:
        dCache = {}
        line = parseData(dCache,dMap)
        print line

        # dump CSV importable onto mysql
        #print personCache
        #genCsvForMySqlImport(dCache)

    print line

    return

def doit():
    dArray = readXls(FILE_NAME)
    saveCsv(dArray)
    
doit()

