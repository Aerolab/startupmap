import requests
from bs4 import BeautifulSoup
import dataset
from thready import threaded
import geocoder
from pygeocoder import Geocoder
from pygeolib import GeocoderError
import json


db = dataset.connect('mysql://startup:startup@10.0.2.2/startups_laravel')
startups = db['startups']


# john = table.find_one(name='John Doe')

# response = requests.get(BASE_URL + "mis/")
def cleanAddressWithGoogle():
	for startup in startups.all():
		print(startup['name'])
		# r = requests.get('https://maps.googleapis.com/maps/api/geocode/json?address='+startup['address']+'&sensor=false&components=country:AR&language=es')
		# req = r.json();
		# g = geocoder.google(startup['address'])
		# g = Geocoder.geocode(startup['address'],language='es')

		try:
		  g = Geocoder.geocode(startup['address'],language='es')
		except GeocoderError:
			print "The address entered could not be geocoded"
			data = {
				'id':startup['id'],
				'address_street': "",
				'address_city': "",
				'address_country': "",
				'address_formatted': "",
				'flag': 'address'
				}
			startups.update(data, ['id'])
		
		if g.valid_address:
			data = {
				'id':startup['id'],
				'address_street': g.route+' '+g.street_number,
				'address_city': g.city,
				'address_country': g.country,
				'address_formatted': g.formatted_address,
				'lat': g.coordinates[0],
				'lon': g.coordinates[1]
				}
			# print (data)
			startups.update(data, ['id'])
			# print(json.dumps(g.jsondata))
		# if req['results'][0]['types'][0] == 'street_address':
		# 	data = {
		# 		'id':startup['id'],
		# 		'address_street': req['results'][0]['address_components'][1]['short_name']+' '+req['results'][0]['address_components'][0]['long_name'],
		# 		'address_city': req['results'][0]['address_components'][4]['long_name'],
		# 		'address_country': req['results'][0]['address_components'][5]['long_name'],
		# 		'lat': req['results'][0]['geometry']['location']['lat'],
		# 		'lon': req['results'][0]['geometry']['location']['lng']
		# 		}
		# 	startups.update(data, ['id'])
		# else:
		# 	print ('skip')


cleanAddressWithGoogle()