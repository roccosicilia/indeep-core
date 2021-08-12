#
# File: setcpe.py
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

# get cve whit unset cpe
sql_cve = "SELECT * FROM `cve` ORDER BY `id`"
cursor.execute(sql_cve)
results = cursor.fetchall()

for result in results:
  # DEBUG
  # print("CEV ID: {0}.".format(result[1]))

  info_str = result[7]
  # DEBUG
  print(info_str)

'''
  if info["cpe"] == 'set':
    print("The CVE {0} was managed".formta(result[1]))
'''