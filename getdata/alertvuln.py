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
results = cursor.fetchall()

for result in results:
    print(result[0])

