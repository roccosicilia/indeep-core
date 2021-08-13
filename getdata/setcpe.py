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
  print("### CPE for {} ################################################".format(result[1]))
  cpe_list = result[5].split(",")
  for cpe in cpe_list:
    print(cpe)

'''
  if result[7] != None:
    info = json.loads(result[7])[0]
    if info['cpe'] != 'set':
      cpe_list = result[5].split(",")
      print(cpe_list)
'''