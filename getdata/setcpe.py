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
sql_cve = "SELECT * FROM `cve` WHERE `cpe_list` != '' AND `cpe_set` != 'set' ORDER BY `id`"
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
    if num_items[0] == 0:
      # add CPE to DB
      cpe_data = cpe.split(":")
      # check cpe format
      if len(cpe_data) == 13:
        sql_cpe_add = "INSERT INTO `cpe` (`cve`, `cpe_string`, `vendor`, `product`, `version`, `update`, `edition`, `language`, `sw_edition`, `target_sw`, `target_hw`, `other`) VALUES ('{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}')".format(result[0], cpe, cpe_data[3], cpe_data[4], cpe_data[5], cpe_data[6], cpe_data[7], cpe_data[8], cpe_data[9], cpe_data[10], cpe_data[11], cpe_data[12])
        cursor.execute(sql_cpe_add)
        connection.commit()
        sql_cpe_set = "UPDATE `cpe` SET `cpe_set` = 'set' WHERE `id` = {0}".format(result[0])
        cursor.execute(sql_cpe_set)
        connection.commit()
        print("++++++ CPE {} add to DB".format(cpe))
      else:
        print("****** CPE not valid.")
    else:
      print("------ CPE {} is present on DB".format(cpe))