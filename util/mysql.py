#!/usr/bin/env python

from __future__ import print_function

import json
import pymysql
import requests



conn = pymysql.connect(host='127.0.0.1', port=3306, user='root', passwd='root', db='startups_laravel')
cur = conn.cursor()
cur.execute("SELECT id,address FROM startups LIMIT 10")

# print(cur.description)

# print()

for row in cur.fetchall():
   
   print ('https://maps.googleapis.com/maps/api/geocode/json?address='+row[1]+'&sensor=false&components=country:AR&language=es')
   r = requests.get('https://maps.googleapis.com/maps/api/geocode/json?address='+row[1]+'&sensor=false&components=country:AR&language=es')
   response = r.json();
   # print(response)
   # print(response['results'][0]['formatted_address'])
   print(response['results'][0]['address_components'][1]['short_name'])
   print(response['results'][0]['address_components'][0]['long_name'])

   print(response['results'][0]['address_components'][3]['long_name'])
   print(response['results'][0]['address_components'][4]['long_name'])
   print(response['results'][0]['address_components'][5]['long_name'])
   print(response['results'][0]['geometry']['location']['lat'])
   print(response['results'][0]['geometry']['location']['lng'])
   # cur.execute("UPDATE WHERE id="+row[0])


cur.close()
conn.close()