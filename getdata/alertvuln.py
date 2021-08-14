#
# File: alertvuln.py
# Author: Rocco Sicilia (aka: Sheliak)
#

from urllib import urlopen
import json
import sys
import mysql.connector

# config file
static = json.load(open("./config.json"))

# DB connection MYSQL
connection = mysql.connector.connect(host=static["db_host"], user=static["db_user"], password=static["db_password"], database=static["db_name"])
cursor = connection.cursor()

# get istance to check
sql_istance = "SELECT DISTINCT `istance_remark` FROM `rule_vulnerability`"
cursor.execute(sql_istance)
istances = cursor.fetchall()

for istance in istances:
    
    print("##################################################")
    print("## Check VULN(s) for istance {0}".format(istance[0]))

    # define cpe for istance
    sql_cpe = "SELECT * FROM `rule_vulnerability` WHERE `istance_remark` = '{}' ORDER BY `id`".format(istance[0])
    cursor.execute(sql_cpe)
    cpe_list = cursor.fetchall()

    for cpe in cpe_list:
        print("## Identified cpe {}:{}".format(cpe[3], cpe[4]))
        # check vuln for cpe_list
        sql_cve = "SELECT * FROM `cve` WHERE `cpe_list` LIKE '{0}:{1}' ORDER BY `cve`"
        cursor.execute(sql_cve)
        cve_list: 