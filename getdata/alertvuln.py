#
# File: alertvuln.py
# Author: Rocco Sicilia (aka: Sheliak)
#

from urllib import urlopen
import json
import sys
import mysql.connector
from datetime import date

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
        sql_cve = "SELECT * FROM `cve` WHERE `cpe_list` LIKE '%{0}:{1}%' AND `cvss` >= {2} ORDER BY `id`".format(cpe[3], cpe[4], cpe[2])
        cursor.execute(sql_cve)
        cve_list = cursor.fetchall()

        for cve in cve_list:
            # print("CVE {0} with score {1} for {2}:{3}".format(cve[1], cve[2], cpe[3], cpe[4]))

            # add in alert_cve table
            sql_check_alert = "SELECT COUNT(*) FROM `alert_cve` WHERE `istance` = '{0}' AND `cve` = '{1}' ORDER BY `id`".format(istance[0], cve[1])
            cursor.execute(sql_check_alert)
            num_items = cursor.fetchone()
            if num_items[0] == 0:
                # add alert
                today = date.today()
                creation_date = today.strftime("%Y-%m-%d")
                print("++ CVE {0} with score {1} for {2}:{3}: add to alert table".format(cve[1], cve[2], cpe[3], cpe[4]))
                sql_alert = "INSERT INTO `alert_cve` (`type`, `istance`, `cve`, `cpe`, `creation_date`) VALUES ('{}', '{}', '{}', '{}', '{}')".format('vuln', cve[1], cpe[3]+':'+cpe[4], creation_date)
                cursor.execute(sql_alert)
                connection.commit()
            else:
                # skip
                print("-- CVE {0} with score {1} for {2}:{3}: record exist".format(cve[1], cve[2], cpe[3], cpe[4]))
