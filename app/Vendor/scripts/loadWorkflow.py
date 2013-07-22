

def updateBudget(filename,fy):
    print "loading budget table..."

    headerdummy, rows = readCSV.readCsv(filename)

    newheader, newrows = convertKeyToDB(rows,fy)
    #setYear(fy)
    #addAdditionalColumn(newrows, BUDGET_ADDITIONAL_COLUMN)

    DBHelper.updateDB(  BUDGET_TABLENAME,
                        newheader,
                        newrows,
                        BUDGET_KEY_COLUMN )


def doit(filename):
    updateRoutes(filename)
    updateBudget(filename,fy)

def usage():
    print "usage: ", sys.argv[0], "<path_to_budget.csv> <fiscal_year>"
    exit()

if len(sys.argv) != 3:
    usage()
    exit()

filename   = sys.argv[1]

doit(filename)

