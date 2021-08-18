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

for cve in lastcve:
    
    print("##################################################")
    print("# Get data for CVE id {0} published {1}, modified {2}.".format(cve["id"], cve["Published"], cve["Modified"]))
    print("# CVSS score: {0}".format(cve["cvss"]))

    cpenum = len(cve["vulnerable_product"])
    cpe_list = ",".join(cve["vulnerable_product"])
    for cpe in cve["vulnerable_product"]:
        print("# {0}".format(cpe))

    # check for duplicate CVE
    sql_checkcve = "SELECT COUNT(*) FROM cve WHERE cve_id = '{0}' AND date_modified = '{1}'".format(cve["id"], cve["Modified"])
    cursor.execute(sql_checkcve)
    num_items = cursor.fetchone()

    print("# [DEBUG] CVE in DB? {0}".format(num_items[0]))
    print("# References: ")
    for reference in cve["references"]:
        print("# {}".format(reference))
    summary = cve["summary"].encode('utf-8').strip()
    print("# Summary: {}".format(summary))

    if num_items[0] == 0:
        sql_addcve = "INSERT INTO cve (cve_id, cvss, date_modified, date_published, cpe_list, description, cve_references) VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', \"{5}\", \"{6}\")".format(cve["id"], cve["cvss"], cve["Modified"], cve["Published"], cpe_list, summary, cve["references"])
        print ("# DEBUG: {}".format(sql_addcve))
        cursor.execute(sql_addcve)
        connection.commit()
        print("# Add CVE in DB.")
    else:
        print("# CVE skipped")
    
    # get CAPEC data
    capec_url = 'https://cve.circl.lu/api/cve/' + cve["id"]
    response_capec = urlopen(capec_url)
    capec_list = json.loads(response_capec.read())

    if capec_list.get('capec') is None:
        print("# No CAPEC")
    else:
        # print(capec_list["capec"])
        print("# There are {} CAPEC".format(len(capec_list["capec"])))
        for capec in capec_list["capec"]:
            # print("# {}".format(capec["name"]))
            # verify if capec is present
            sql_check_capec = "SELECT COUNT(*) FROM `cve_capec` WHERE `cve_id` = '{}' AND `name` = '{}' ORDER BY `id`".format(cve["id"], capec["name"])
            cursor.execute(sql_check_capec)
            num_capec = cursor.fetchone()

            if num_capec[0] == 0:
                sql_add_capec = "INSERT INTO `cve_capec` (`cve_id`, `name`, `prerequisites`, `summary`, `solutions`) VALUES ('{}', '{}', '{}', '{}', '{}')".format(cve["id"], capec["name"].encode('utf-8').strip(), capec["prerequisites"].encode('utf-8').strip(), capec["summary"].encode('utf-8').strip(), capec["solutions"].encode('utf-8').strip())
                cursor.execute(sql_add_capec)
                connection.commit()
                print("# Add CAPEC '{}'".format(capec["name"]))
            else:
                print("# CAPEC Skipped")