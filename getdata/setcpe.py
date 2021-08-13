#
# File: setcpe.py
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

# get cve whit unset cpe
sql_cve = "SELECT * FROM `cve` WHERE `cpe_list` != '' AND `cpe_set` IS NULL ORDER BY `id`"
cursor.execute(sql_cve)
results = cursor.fetchall()

for result in results:
  print("### CPE for {0} ################################################".format(result[1]))
  cpe_list = result[5].split(",")
  for cpe in cpe_list:
    # check if CPE is present
    sql_cpe = "SELECT COUNT(*) FROM `cpe` WHERE `cve` = '{0}' AND `cpe_string` = '{1}'".format(result[0], cpe)
    cursor.execute(sql_cpe)
    num_items = cursor.fetchone()
    print(num_items[0])
