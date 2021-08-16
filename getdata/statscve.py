#
# File: statscve.py
# Author: Rocco Sicilia (aka: Sheliak)
#

from urllib import urlopen
import json
import mysql.connector
import sys
from datetime import date

# config file
static = json.load(open("./config.json"))

# DB connection MYSQL
connection = mysql.connector.connect(host=static["db_host"], user=static["db_user"], password=static["db_password"], database=static["db_name"])
cursor = connection.cursor()

# CVE per day
if sys.argv[1] != None:
    check_date = sys.argv[1]
else:
    today = date.today()
    check_date = today.strftime("%Y-%m-%d")

sql_cve = "SELECT COUNT(*) FROM `cve` WHERE `date_modified` LIKE '{}%'".format(check_date)
cursor.execute(sql_cve)
num_items = cursor.fetchone()
num_cve = num_items[0]

sql_cve_overnine = "SELECT COUNT(*) FROM `cve` WHERE `date_modified` LIKE '{}%' AND `cvss` => '9'".format(check_date)
cursor.execute(sql_cve_overnine)
num_items = cursor.fetchone()
num_cve_overnine = num_items[0]

sql_cve_stat = "INSERT INTO `cve_stats` (`name`, `date`, `a_name`, `a_value`, `b_name`, `b_value`) VALUES ('{}', '{}', '{}', '{}', '{}', '{}')".format('CVE per Day', check_date, 'cve(s)', num_cve, 'overnine', num_cve_overnine)
cursor.execute(sql_cve_stat)
connection.commit()
