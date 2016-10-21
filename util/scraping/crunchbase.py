import requests
from bs4 import BeautifulSoup
import dataset
import json
import geocoder
from pygeocoder import Geocoder
from pygeolib import GeocoderError

data = [{"/company/acamica":"/company/afluenta"},
{"/company/acamica":"/company/almashopping"},
{"/company/acamica":"/company/attender"},
{"/company/acamica":"/company/azonia"},
{"/company/acamica":"/company/bioscience"},
{"/company/acamica":"/company/buscoturno"},
{"/company/acamica":"/company/citibuddies"},
{"/company/acamica":"/company/clippate"},
{"/company/acamica":"/company/club-point"},
{"/company/acamica":"/company/codamation"},
{"/company/acamica":"/company/codealike"},
{"/company/acamica":"/company/cupoint"},
{"/company/acamica":"/company/datam"},
{"/company/acamica":"/company/dineromail"},
{"/company/acamica":"/company/dinerotaxi"},
{"/company/acamica":"/company/double-doods"},
{"/company/acamica":"/company/eland"},
{"/company/acamica":"/company/fancybox"},
{"/company/acamica":"/company/fanwards"},
{"/company/acamica":"/company/fligoo"},
{"/company/acamica":"/company/flipaste"},
{"/company/acamica":"/company/formafina"},
{"/company/acamica":"/company/globant"},
{"/company/acamica":"/company/gointegro"},
{"/company/acamica":"/company/groovinads"},
{"/company/acamica":"/company/hacemeunregalo-com"},
{"/company/acamica":"/company/hesiodo"},
{"/company/acamica":"/company/homeviva"},
{"/company/acamica":"/company/hunt-m-ads"},
{"/company/acamica":"/company/incluyeme-com"},
{"/company/acamica":"/company/increasecard"},
{"/company/acamica":"/company/infoxel"},
{"/company/acamica":"/company/intelicalls"},
{"/company/acamica":"/company/invertironline-com"},
{"/company/acamica":"/company/joincube-com"},
{"/company/acamica":"/company/keclon"},
{"/company/acamica":"/company/keegy"},
{"/company/acamica":"/company/keepcon"},
{"/company/acamica":"/company/larala-com"},
{"/company/acamica":"/company/latinda"},
{"/company/acamica":"/company/legalfcil"},
{"/company/acamica":"/company/livra"},
{"/company/acamica":"/company/logan"},
{"/company/acamica":"/company/micursada"},
{"/company/acamica":"/company/mind-factoryar"},
{"/company/acamica":"/company/mindset-studio"},
{"/company/acamica":"/company/mis-descuentos"},
{"/company/acamica":"/company/multizona-com"},
{"/company/acamica":"/company/mundohablado-com"},
{"/company/acamica":"/company/mural-ly"},
{"/company/acamica":"/company/navent"},
{"/company/acamica":"/company/nubity"},
{"/company/acamica":"/company/ofelia-feliz"},
{"/company/acamica":"/company/okeyko"},
{"/company/acamica":"/company/om-latam"},
{"/company/acamica":"/company/orugga"},
{"/company/acamica":"/company/pagatualquiler"},
{"/company/acamica":"/company/parsimotion"},
{"/company/acamica":"/company/pigit"},
{"/company/acamica":"/company/plored"},
{"/company/acamica":"/company/polisofia"},
{"/company/acamica":"/company/posibl"},
{"/company/acamica":"/company/postcron"},
{"/company/acamica":"/company/properati"},
{"/company/acamica":"/company/psicofxp-com"},
{"/company/acamica":"/company/quasar-ventures"},
{"/company/acamica":"/company/quolaw"},
{"/company/acamica":"/company/resermap"},
{"/company/acamica":"/company/restorando-com"},
{"/company/acamica":"/company/rock-n-roll-game-studio-s-a"},
{"/company/acamica":"/company/root4"},
{"/company/acamica":"/company/ropit"},
{"/company/acamica":"/company/safertaxi"},
{"/company/acamica":"/company/shopear"},
{"/company/acamica":"/company/sinimanes"},
{"/company/acamica":"/company/soicos"},
{"/company/acamica":"/company/soloingles-com-internacional"},
{"/company/acamica":"/company/sonico"},
{"/company/acamica":"/company/soukboard"},
{"/company/acamica":"/company/sumavisos"},
{"/company/acamica":"/company/t-art"},
{"/company/acamica":"/company/taggify"},
{"/company/acamica":"/company/ticket-hoy"},
{"/company/acamica":"/company/tienda-nube"},
{"/company/acamica":"/company/trendsetters"},
{"/company/acamica":"/company/tuquejasuma"},
{"/company/acamica":"/company/unicotrip"},
{"/company/acamica":"/company/ventas-privadas"},
{"/company/acamica":"/company/viflux"},
{"/company/acamica":"/company/viralica"},
{"/company/acamica":"/company/vontrip"},
{"/company/acamica":"/company/volks"},
{"/company/acamica":"/company/voolks-sa"},
{"/company/acamica":"/company/vostu"},
{"/company/acamica":"/company/vu-security"},
{"/company/acamica":"/company/vulev"},
{"/company/acamica":"/company/widow-games"},
{"/company/acamica":"/company/zauber"},
{"/company/acamica":"/company/zupcat"}];

r = requests.get('http://www.crunchbase.com/organization/hunt-m-ads')
soup = BeautifulSoup(r.content)

get_address = soup.find("ul", { "class" : "office" })
get_address = get_address.findAll('li')
for this_address in get_address:
	get_address = this_address.findAll('p')
	address = ''
	for child in get_address:
	    address += ' '+child.getText()
	print address
	try:
		g = Geocoder.geocode(address,language='es')
	  	if g.valid_address:
			data = {
				# 'id':startup['id'],
				'address_street': g.route+' '+g.street_number,
				'address_city': g.city,
				'address_country': g.country,
				'address_formatted': g.formatted_address,
				'lat': g.coordinates[0],
				'lon': g.coordinates[1]
				}
			print (data)
			print ''
	except GeocoderError:
		print "The address entered could not be geocoded"
		# data = {
		# 	'id':startup['id'],
		# 	'address_street': "",
		# 	'address_city': "",
		# 	'address_country': "",
		# 	'address_formatted': "",
		# 	'flag': 'address'
		# 	}
		# startups.update(data, ['id'])


	# startups.update(data, ['id'])
# print ' '.join(children)
# print geo
# print address