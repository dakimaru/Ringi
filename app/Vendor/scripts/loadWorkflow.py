import sys

import readCSV
import DBHelper

USER_CSV_DN             = "DN"
USER_CSV_USERNAME       = "username"
USER_CSV_TITLE          = "title"
USER_CSV_MAIL           = "mail"
USER_CSV_DEPARTMENT     = "department"
USER_CSV_NAME           = "name"
USER_CSV_MANAGER        = "manager"

ROUTES_TABLENAME        = "ROUTES"
ROUTES_PERSON           = "person"
ROUTES_TITLE            = "approvertitle"
ROUTES_DEPARTMENT       = "department"
ROUTES_APPROVERLAYER    = "approverLayer"
ROUTES_APPROVERDEPT     = "approverDept"
ROUTES_APPROVERID       = "approverID"
ROUTES_KEY_COLUMNS  = [ 
                        ROUTES_PERSON,
                        ROUTES_DEPARTMENT,
                        ROUTES_TITLE,        
                      ]
ROUTES_HEADER_COLUMNS = ROUTES_KEY_COLUMNS + \
                      [ 
                        ROUTES_APPROVERLAYER,
                        ROUTES_APPROVERDEPT,
                        ROUTES_APPROVERID,
                      ]

USER_ROUTES_MAP =       {
                        USER_CSV_USERNAME   : ROUTES_PERSON,
                        USER_CSV_TITLE      : ROUTES_TITLE,
                        USER_CSV_DEPARTMENT : ROUTES_DEPARTMENT,
                        } 
MANAGER_ROUTES_MAP =    {
                        USER_CSV_DEPARTMENT : ROUTES_APPROVERDEPT,
                        USER_CSV_TITLE      : ROUTES_TITLE,
                        USER_CSV_USERNAME   : ROUTES_APPROVERID,
                        } 
MAXIMUM_LAYER           = 5
MARKER_VISITED          = "_visited"

OPTION_USER = 1
OPTION_DEPT = 2

def hasManager(user):
    #print "### hasManager : ", user[USER_CSV_MANAGER]
    if user[USER_CSV_MANAGER] == "":
        return False
    return True

def getManager(user, users):
    #print "### getManager ###"
    if not hasManager(user):
        return None

    managerDN = user[USER_CSV_MANAGER]
    #print "### managerDN : ", managerDN
    for u in users:
        #print ">> DN comparison:",managerDN, u[USER_CSV_DN]
        if managerDN == u[USER_CSV_DN]:
            return u

    print "manager", managerDN, "not found" 
    return None

def userVisited(user):
    if MARKER_VISITED in user:
        return True
    return False

def markVisited(user):
    user[MARKER_VISITED] = True

def createLayer(option,user,manager,layerDepth):
    aLayerMap = {}
    for userKey,routeKey in USER_ROUTES_MAP.items():
        aLayerMap[routeKey] = user[userKey]
    for userKey,routeKey in MANAGER_ROUTES_MAP.items():
        aLayerMap[routeKey] = manager[userKey]
    aLayerMap[ROUTES_APPROVERLAYER] = layerDepth
    
    if option == OPTION_DEPT:
        aLayerMap[ROUTES_PERSON] = ""

    #print "createLayer, create to be added: ", aLayerMap
    return aLayerMap
    
def getApprovalFlow(option,user,users,layerDepth):

    if layerDepth > MAXIMUM_LAYER:
        print "Approval flow for", user[USER_CSV_USERNAME], "exceeded maximum layer depth."
        return []

    manager = getManager(user,users)
    if manager:
        #print ">>manager find:", manager
        aLayer  = createLayer(option,user,manager,layerDepth)
        aFlow   = getApprovalFlow(option,manager,users,layerDepth+1)
        aFlow.append(aLayer)
        return aFlow

    return []

def analyzeUserTree(option,users):
    print "analyzing user tree..."

    appFlows = []

    # visit all users, checking if they are managers
    for user in users:
        manager = getManager(user, users)
        if(not manager):
            print "no manager assigned for ", user
            continue
        markVisited(manager)
 
    # retrieve user hierarchy only for leave user
    for user in users:
        if( userVisited(user) ):
            continue

        # if User, [(User,Title,Dept),(User,Title,Dept)...]
        # if Dept, [(Title,Dept),[Title,Dept)...]
        appFlow = getApprovalFlow(option, user, users, 1)
        if( not appFlow[0] in appFlows ):
            #print ">>> adding new", appFlow, " as not found in ", appFlows
            appFlows.append(appFlow[0])

    return ROUTES_HEADER_COLUMNS, appFlows

def doit(filename, option):
    header,rows = readCSV.readCsv(filename)

    newheader,newrows = analyzeUserTree(option,rows)

    print "loading workflow to DB...."
    print "  flows to import: ", newrows
    DBHelper.updateDB(  ROUTES_TABLENAME,
                        newheader,
                        newrows,
                        ROUTES_KEY_COLUMNS )

def usage():
    print "usage: ", sys.argv[0], "<path_to_usertable.csv> <user or dept>"
    exit()

if len(sys.argv) != 3:
    usage()
    exit()

filename   = sys.argv[1]
option     = sys.argv[2]

if not option in ['user', 'dept']:
    usage()
    exit()

if option=='user':
    option = OPTION_USER
else:
    option =OPTION_DEPT

doit(filename, option)

