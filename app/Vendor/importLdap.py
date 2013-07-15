import ConfigParser
import ldap
import ldap.modlist as modlist
import sys
import csv

CSV_INPUT = 'usertable.csv'
DEFAULT_PASSWORD = 'root'

parser = ConfigParser.SafeConfigParser()
parser.read('importLdap.ini')

# Active Directory attributes
src_attrs = [ 
        'DN',
        'cn',
        'departmentNumber',
        'mail',
        'manager',
        'name',
        'title',
        'userPassword',
       ]

additional_attr_vals = {
        'sn': 'dummy',
}

def getLDAPConn(serverToConnect):
    ldapHostUrl = 'ldap://' + parser.get(serverToConnect,'host')
    #print 'ldapHostUrl=', ldapHostUrl
    con = ldap.initialize(ldapHostUrl)
    if( not con ):
        return None

    #print 'connected to LDAP server', con    
    return con

def bindLDAPServer(serverToConnect, ldapConn):
    adminDN  = parser.get(serverToConnect,'admin_dn')
    adminPwd = parser.get(serverToConnect,'admin_pwd')

    ldapObj = ldapConn.simple_bind_s(adminDN, adminPwd)
    if( ldapObj[0] != 97 ):
        return None

    #print 'bind successful :', ldapObj
    return ldapObj

def getLDAPServer(serverToConnect):
    con = getLDAPConn(serverToConnect)

    if( not con ):
        print 'host not reachable'
        return None

    bindResult = bindLDAPServer(serverToConnect, con)
    if( not bindResult ):
        print 'not found LDAP server' 
        return None

    return con

def convertToMap(columns, row):
    map = {}
    for i in range(len(columns)):
        if not columns[i] in src_attrs:
            print 'column is not required to add to Map :' , columns[i]
            continue
        key = columns[i]
        val = row[i]
        map[key] = val

    map.update(additional_attr_vals)
    print map
    return map

def loadCsv():
    columns = []
    rows    = []
    with open(CSV_INPUT, 'rb') as csvfile:
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

def resetPassword(dn,row,ldapConn):
    ldapConn.passwd_s( dn, None, DEFAULT_PASSWORD )

def updateUser(row,ldapConn):
    print row
    attrs = {}
    dn = row['DN']
    attrs['objectclass'] = ['top','person','organizationalPerson','inetOrgPerson']
    # attrs['DN'] = dn
    for key in row.keys():
        attrs[key] = row[key]

    del attrs['DN']
    try:
        ldif = modlist.addModlist(attrs)
        ldapConn.add_s(dn,ldif)
    except:
        ldif = modlist.modifyModlist(attrs,attrs)
        ldapConn.modify_s(dn,ldif)

    resetPassword(dn,row,ldapConn)

def updateUsers(rows,ldapConn):
    for row in rows:
        updateUser(row,ldapConn)


#### main function

def doit(ldapServer):
    ldapConn=getLDAPServer(ldapServer)
    (col,rows) = loadCsv()
    updateUsers(rows,ldapConn)
    ldapConn.unbind_s()

doit('dest_ldap')
