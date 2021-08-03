#
# File: getcve.py
# Author: Rocco Sicilia (aka: Sheliak)
#

from urllib import urlopen
import json
import mysql.connector

# config file
static = json.load(open("./config.json"))

# DB connection MYSQL
connection = mysql.connector.connect(host=static["db_host"], user=static["db_user"], password=static["db_password"], database=static["db_name"])
cursor = connection.cursor()

# DB connection PGSQL
# connection = psycopg2.connect(user=static["db_user"], password=static["db_password"], host=static["db_host"], port=static["db_port"], database=static["db_name"])
# cursor = connection.cursor()

# get data from CIRCL
url = "https://cve.circl.lu/api/last"
response = urlopen(url)
lastcve = json.loads(response.read())

cvenum = len(lastcve)
print("##################################################")
print("# There are {0} CVE in this list.".format(cvenum))
print("#")

i = 0 # cve counter

for cve in lastcve:
    
    print("##################################################")
    print("# Get data for CVE id {0} published {1}, modified {2}.".format(cve["id"], cve["Published"], cve["Modified"]))
    print("# CVSS score: {0}".format(cve["cvss"]))

    cpenum = len(cve["vulnerable_product"])
    cpe_list = ",".join(cve["vulnerable_product"])
    for cpe in cve["vulnerable_product"]:
        print("# {0}".format(cpe))

    # check for duplicate CVE
    sql_checkcve = "SELECT * FROM cve WHERE cve_id = '{0}' AND date_modified = '{1}'".format(cve["id"], cve["Modified"])
    cursor.execute(sql_checkcve)

    if cursor.rowcount == 0:
        sql_addcve = "INSERT INTO cve (cve_id, cvss, date_modified, date_published, cpe_list) VALUES ('{0}', '{1}', '{2}', '{3}', '{4}')".format(cve["id"], cve["cvss"], cve["Modified"], cve["Published"], cpe_list)
        cursor.execute(sql_addcve)
        connection.commit()
        print("# Add CVE in DB.")
        ++i
    else:
        print("# CVE skipped")


print("##################################################")
print("#")
print("# Add {0} CVE".format(i))
print("#")
print("##################################################\n")
