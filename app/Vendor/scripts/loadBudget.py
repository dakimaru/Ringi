import CSVHelper
import DBHelper
from datetime import date
import copy
import sys

## Master Table Definition
dept_code   ={}
line_code   ={}
project     ={}
account_code={}
description ={}
purpose     ={}

MASTER_EX_DEPT_CODE     = 'Dept_Code'
MASTER_EX_LINE_CODE     = 'Line_Code'
MASTER_EX_PROJECT       = 'Project'
MASTER_EX_ACCOUNT_CODE  = 'Account_Code'
MASTER_EX_DESCRIPTION   = 'Description'
MASTER_EX_PURPOSE       = 'Purpose'
MASTER_EX_BENEFIT       = 'Benefit'
MASTER_EX_TOTAL         = 'Total'
MASTER_EX_MONTHS        = { 
                          "April"   :4,
                          "May"     :5,
                          "June"    :6,
                          "July"    :7,
                          "Aug"     :8,
                          "Sep"     :9,
                          "Oct"     :10,
                          "Nov"     :11,
                          "Dec"     :12,
                          "Jan"     :1,
                          "Feb"     :2,
                          "Mar"     :3,
                        } 
CODE_MAP                = { 
                          MASTER_EX_DEPT_CODE    : dept_code,
                          MASTER_EX_LINE_CODE    : line_code,
                          MASTER_EX_PROJECT      : project,
                          MASTER_EX_ACCOUNT_CODE : account_code,
                          MASTER_EX_DESCRIPTION  : description,
                          MASTER_EX_PURPOSE      : purpose,
                        }

MASTER_TABLENAME        = 'names'
MASTER_KEY_COLUMN_ENUM  = 'nameType'
MASTER_KEY_COLUMN_NAME  = 'name'
MASTER_KEY_COLUMN_VALUE = 'nameCD'
MASTER_TABLEHEADER      = [ 
                          MASTER_KEY_COLUMN_ENUM, 
                          MASTER_KEY_COLUMN_NAME, 
                          MASTER_KEY_COLUMN_VALUE,
                        ]
MASTER_PRIMARY_KEYS     = [ 
                          MASTER_KEY_COLUMN_ENUM, 
                          MASTER_KEY_COLUMN_NAME,
                        ]

## Budget Table Definition
BUDGET_TABLENAME        = 'BUDGETS'
BUDGET_DB_YEAR          = 'year'
BUDGET_DB_MONTH         = 'month'
BUDGET_DB_DEPARTMENT    = 'department'
BUDGET_DB_LINECD        = 'lineCd'
BUDGET_DB_PROJECT       = 'project'
BUDGET_DB_ACCOUNTNO     = 'accountno'
BUDGET_DB_SOURCE        = 'source'
BUDGET_DB_PURPOSE       = 'purpose'
BUDGET_DB_BUDGET        = 'budget'
BUDGET_DB_BENEFIT       = 'benefit'
BUDGET_EXCEL_TO_DB_CONV = {
                          MASTER_EX_DEPT_CODE    : BUDGET_DB_DEPARTMENT,
                          MASTER_EX_LINE_CODE    : BUDGET_DB_LINECD,
                          MASTER_EX_PROJECT      : BUDGET_DB_PROJECT,
                          MASTER_EX_ACCOUNT_CODE : BUDGET_DB_ACCOUNTNO,
                          MASTER_EX_DESCRIPTION  : BUDGET_DB_SOURCE,
                          MASTER_EX_PURPOSE      : BUDGET_DB_PURPOSE,
                          MASTER_EX_BENEFIT      : BUDGET_DB_BENEFIT,
                        }
BUDGET_KEY_COLUMN       = [ 
                          BUDGET_DB_YEAR,  
                          BUDGET_DB_MONTH,  
                          BUDGET_DB_DEPARTMENT, 
                          BUDGET_DB_LINECD, 
                          BUDGET_DB_PROJECT, 
                          BUDGET_DB_ACCOUNTNO,
                          BUDGET_DB_SOURCE, 
                          BUDGET_DB_PURPOSE, 
                        ]
BUDGET_ADDITIONAL_COLUMN= { 
                          BUDGET_DB_YEAR : date.today().year,
                        }
BUDGET_FISCAL_YEAR      = '2013'

def genEnumNamesArray(enum, names):
    rows = []
    for n in names:
        map = {}
        map[MASTER_KEY_COLUMN_ENUM]  = enum
        map[MASTER_KEY_COLUMN_NAME]  = n
        map[MASTER_KEY_COLUMN_VALUE] = None
        rows.append(map)

    return rows

# create codeMap = EnumName => {'var1':None, 'var2':None, ...}
def genCodeMap(r):
    for code,cmap in CODE_MAP.items():
        #print code, cmap
        cmap[r[code]] = None

def setYear(year):
    BUDGET_ADDITIONAL_COLUMN[BUDGET_DB_YEAR] = year

def addAdditionalColumn(rows, additionalColumns):
    for r in rows:
        r.update(additionalColumns)

def updateMaster(filename):
    print "loading Master tables..."

    header, rows = CSVHelper.readCsv(filename)
    for r in rows:
        genCodeMap(r)

    rows = []
    print "====> Code map generated: "
    for enum,map in CODE_MAP.items():
        #print enum
        #print map
        rows = rows + genEnumNamesArray(enum, map.keys())

    print "====> Rows to be inserted: "
    for r in rows:
        print r
    DBHelper.updateDBIncremental(   MASTER_TABLENAME,
                                    MASTER_TABLEHEADER,
                                    rows,
                                    MASTER_KEY_COLUMN_ENUM,
                                    MASTER_PRIMARY_KEYS,
                                    MASTER_KEY_COLUMN_VALUE )
def convertKeyToDB(rows,fy):
    newheader = BUDGET_EXCEL_TO_DB_CONV.values() \
                + [BUDGET_DB_YEAR, BUDGET_DB_MONTH, BUDGET_DB_BUDGET]
    newrows = []
    for row in rows:
        newrow = {}
        for ex,db in BUDGET_EXCEL_TO_DB_CONV.items():
            newrow[db] = row[ex]
        for monStr,monDigit in MASTER_EX_MONTHS.items():
            newrow[BUDGET_DB_YEAR]   = fy
            newrow[BUDGET_DB_MONTH]  = monDigit
            newrow[BUDGET_DB_BUDGET] = row[monStr]
            #print newrow
            newrows.append(copy.copy(newrow))

    return (newheader, newrows)
        
def updateBudget(filename,fy):
    print "loading budget table..." 

    headerdummy, rows = CSVHelper.readCsv(filename)

    newheader, newrows = convertKeyToDB(rows,fy)
    #setYear(fy)
    #addAdditionalColumn(newrows, BUDGET_ADDITIONAL_COLUMN)

    DBHelper.updateDB(  BUDGET_TABLENAME,
                        newheader,
                        newrows,
                        BUDGET_KEY_COLUMN )


def doit(filename,fy):
    updateMaster(filename)
    updateBudget(filename,fy)

def usage():
    print "usage: ", sys.argv[0], "<path_to_budget.csv> <fiscal_year>"
    exit()

if len(sys.argv) != 3:
    usage()
    exit()

filename   = sys.argv[1]
fiscalYear = sys.argv[2]
 
doit(filename,fiscalYear)
