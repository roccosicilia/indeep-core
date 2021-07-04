
from urllib.request import urlopen
import json
import psycopg2

connection = psycopg2.connect(user="myuser", password="mypassword", host="localhost", port="5432", database="indeep")
cursor = connection.cursor()

url = "https://cve.circl.lu/api/last"
response = urlopen(url)
lastcve = json.loads(response.read())

cvenum = len(lastcve)
print("##################################################")
print("# There are {0} CVE in this list.".format(cvenum))
print("#")

for cve in lastcve:
    
    print("##################################################")
    print("# Get data for CVE id {0} published {1}, modified {2}.".format(cve["id"], cve["Published"], cve["Modified"]))
    
    print("#")
    print("# CVSS score: {0}".format(cve["cvss"]))
    
    print("#")
    cpenum = len(cve["vulnerable_product"])
    cpe_list = ",".join(cve["vulnerable_product"])
    for cpe in cve["vulnerable_product"]:
        print("# {0}".format(cpe))

    # check for duplicate CVE
    sql_checkcve = "SELECT * FROM cve WHERE cveid = '{0}' AND date_modified = '{1}'".format(cve["id"], cve["Modified"])
    cursor.execute(sql_checkcve)
    cveindb = cursor.rowcount

    if cursor.rowcount == 0:
        sql_addcve = "INSERT INTO cve (cveid, cvss, date_modified, date_published, cpe_list) VALUES ('{0}', '{1}', '{2}', '{3}', '{4}')".format(cve["id"], cve["cvss"], cve["Modified"], cve["Published"], cpe_list)
        cursor.execute(sql_addcve)
        connection.commit()
        print("# Add CVE in DB.")
    else:
        print("# CVE skipped")
