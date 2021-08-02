#
# File: getrecord.py
# Author: Rocco Sicilia (aka: Sheliak)
#

from urllib.request import urlopen
import json
import psycopg2
import sys, argparse
import dns.query
import dns.zone
import dns.resolver

# config file
static = json.load(open("./config.json"))

# DB connection
connection = psycopg2.connect(user=static["db_user"], password=static["db_password"], host=static["db_host"], port=static["db_port"], database=static["db_name"])
cursor = connection.cursor()

# get domain name
domain = sys.argv[1]

# get A records
arecords = resolver.query(domain , "A")
print("The A records are {0}".format(arecords))
