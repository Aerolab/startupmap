function addUserImg(){$(".userPanel img").attr("src",window.env.user.picture),$(".userPanel").addClass("logged")}function categoriesHoverActive(){$("#categories").hoverIntent(function(){initialListLeft=50,initialViewLeft=100,$("#list").css("left",initialListLeft+100)},function(){$("#list").css("left",initialListLeft)})}function changeMapCountry(e,a){e!=window.env.country.iso&&(window.env.country=window.env.countryList[e],$selectizeCountry[0].selectize.setValue(e),$mapCountrySelector[0].selectize.setValue(e),getMarkers(null,null,a),History.replaceState({},"StartupMap - Mapa de Startups Latinoamericanas","/"+window.env.country.slug),a||(rightSidebarClose(),sidebarOpen&&$("#toggle-nav").wait(80).trigger("click")))}function getMarkers(e,a,r){r="undefined"!=typeof r?r:!1,mapRequest={country:window.env.country.iso},"undefined"!=typeof a&&(mapRequest.text=a),"undefined"!=typeof e&&(mapRequest.categories=e),$.ajax({url:window.env.endpoint+"startup/map",type:"POST",dataType:"json",data:mapRequest,success:function(e){"object"==typeof markerCluster&&(map.removeLayer(markerCluster),markerCluster=null,markers=[],categories=[]),markerCluster=new L.MarkerClusterGroup({showCoverageOnHover:!1,disableClusteringAtZoom:19,maxClusterRadius:90,spiderfyOnMaxZoom:!0,iconCreateFunction:function(e){var a=e.getChildCount(),r=" marker-cluster-";return r+=4>a?"small":30>a?"medium":"large",new L.DivIcon({html:"<div><span>"+a+"</span></div>",className:"marker-cluster"+r,iconSize:new L.Point(35,35)})}});var a;$.each(e,function(e,a){""==a.banner&&(a.banner="/generic/banner"+Math.floor(4*Math.random()+1)+".png"),a.social=""!=a.facebook||""!=a.twitter||""!=a.linkedin||""!=a.crunchbase||""!=a.angelist||""!=a.dribbble||""!=a.google_plus||""!=a.foursquare?!0:!1;var r=L.marker([a.lat,a.lon],{id:a.id,name:a.name,slug:a.slug,category_id:a.category_id,category_slug:a.category_slug,array_key:e,data:a,icon:L.AwesomeMarkers.icon({icon:a.category_name.toLowerCase(),markerColor:MarkerColor[a.category_id],className:"marker company-"+a.id})});if(r.on("click",function(e){startupPanel(a.id)}),markers.push(r),markerCluster.addLayer(r),"undefined"!=typeof a.category_id){category={id:a.category_id,name:a.category_name,slug:a.category_slug};var t=!1;for(var o in categories)"undefined"!=typeof categories[o].id&&categories[o].id==a.category_id&&(t=!0);0==t&&categories.push(category)}}),map.addLayer(markerCluster),r||map.fitBounds(markerCluster),fillCategories(),"0"!=window.env.startup&&(startupPanel(window.env.startup),window.env.startup="0")}})}function fillCategories(){$("#categories ul").html("");var e='<li class="list-all"><a href="/'+window.env.country.slug+'/all" class="openList" data-id="all"><i class="icon-all"></i>All <span>'+markers.length+"</span></a></li>";$(e).appendTo("#categories ul");for(var a in categories){var r=categories[a].name.toLowerCase(),t=$.grep(markers,function(e){return e.options.category_id==categories[a].id}).length,e='<li class="list-'+r+'"><a href="/'+window.env.country.slug+"/"+categories[a].slug+'" class="openList" data-id="'+categories[a].id+'"><i class="icon-'+r+'"></i>'+categories[a].name+" <span>"+t+"</span></a></li>";$(e).appendTo("#categories ul")}}function loadList(e){if(showMarkers(e),"all"!=e)var a=$.grep(markers,function(a){return a.options.category_id==e});else var a=markers;var r={};r.amount=a.length,r.id=e,r.items=a;var t=$("#itemsTemplate").html();Mustache.parse(t);var o=Mustache.render(t,r);return oldPanel=$(".itemsList > div").attr("data-category"),oldPanel==e?!1:($(o).appendTo(".itemsList").css("left",400).wait(100).css("left",0),$('div[data-category="'+oldPanel+'"]').wait(450).remove(),void $("#list").addClass("openList"))}function showMarkers(e){var a=[];if("all"==e)for(var r in markers){var t=markers[r];markerCluster.hasLayer(t)||markerCluster.addLayer(t)}else for(var r in markers){var t=markers[r];markerCluster.hasLayer(t)||markerCluster.addLayer(t),t.options.category_id!=e?markerCluster.hasLayer(t)&&markerCluster.removeLayer(t):a.push(t._latlng)}}function startupPanel(e){if(oldPanel=$("#sidebar div.startupView.active").attr("data-id"),oldPanel=="startup-"+e)return!1;$('div[data-id="'+oldPanel+'"]').wait(450).remove();var a=$.grep(markers,function(a){return a.options.id==e})[0],r=$("#startupTemplate").html();Mustache.parse(r);var t=Mustache.render(r,a);$(t).appendTo(".panel").wait(100).queue(function(){$(this).addClass("active")}),sidebarOpen||($("#toggle-nav").wait(sidebarAnimationWait).addClass("active"),$("body").addClass("sidebar-open"),sidebarOpen=!0),userSidebarOpen&&rightSidebarClose(),map._size.x=$(window).width()-370,map.fitBounds([a._latlng],{maxZoom:17}),$("#map .marker").removeClass("active"),setTimeout(function(){$("#map .marker.company-"+e).addClass("active")},400),History.replaceState({},a.options.name+" - StartupMap","/"+a.options.data.country_slug+"/"+a.options.category_slug+"/"+a.options.id+"/"+a.options.slug),ga("send","pageview","/"+a.options.category_slug+"/"+a.options.slug)}function findCategoryByID(e){return $.grep(categories,function(a){return a.id==e})[0]}function findMarkerByID(e){return $.grep(markers,function(a){return a.options.id==e})[0]}function panToMarker(e){map.panTo(markers[e]._latlng)}function hideMarker(e){var a=markers[e];markerCluster.hasLayer(a)&&markerCluster.removeLayer(a)}function showMarker(e){var a=markers[e];markerCluster.hasLayer(a)||markerCluster.addLayer(a)}function rightSidebarOpen(){$(".control").removeClass("error"),sidebarOpen&&$("#toggle-nav").wait(80).trigger("click"),$("body").addClass("userSidebar-open"),map._size.x=$(window).width()-370,userSidebarOpen=!0,closeEditView()}function rightSidebarClose(){$("body").removeClass("userSidebar-open"),map._size.x=$(window).width(),"object"==typeof newMarker&&(map.removeLayer(newMarker),newMarker=!1),userSidebarOpen=!1}function geolocate(){if(""==$("#startupCreateStreet").val()||"undefined"==typeof $("#startupCreateStreet").val())return!1;if(""==$("#startupCreateCity").val()||"undefined"==typeof $("#startupCreateCity").val())return!1;var e=$("#startupCreateStreet").val()+" "+$("#startupCreateCity").val()+" "+$("#startupCreateCountry").val(),a="http://maps.googleapis.com/maps/api/geocode/json?address="+e+"&sensor=true&language=es&components=country:"+$("#startupCreateCountry").val();$.get(a,{},function(e){if("OK"!=e.status)return!1;if(e.results.length>1)geoData.results=e.results,showOptions();else{$(".address_options").html("");var a=[e.results[0].geometry.location.lat,e.results[0].geometry.location.lng];geolocateSetMarker(a),map.panTo(a),map.setZoom(17)}return"function"==typeof callback?callback():this},"json")}function geolocateSetMarker(e){return e&&""!=e?(newMarker?newMarker.setLatLng(e,{draggable:"true"}).update():(newMarker=new L.marker(e,{draggable:"false",icon:L.AwesomeMarkers.icon({markerColor:"blue",icon:"add"})}),map.addLayer(newMarker)),$("#startupCreateLat").val(e[0]),void $("#startupCreateLon").val(e[1])):!1}function closeEditView(){$(".edit-only").hide(),$(".add-only").show(),$(".success").hide(),$("#uploadBannerArea").removeAttr("style"),$("#uploadLogoArea").removeAttr("style"),$("#uploadBannerArea").html('<i class="fa fa-cloud-upload"></i>'),$("#uploadLogoArea").html('<i class="fa fa-cloud-upload"></i>'),$selectizeCat[0].selectize.clear(),$selectizeTag[0].selectize.clear(),$selectizeCity[0].selectize.clear(),$("#startupCreate input").each(function(){$(this).val("")}),$("#startupCreate textarea").val(""),$selectizeCountry[0].selectize.setValue(window.env.country.iso)}function openEditView(e){console.log("Edit "+e),rightSidebarOpen(),$("#addStartup").attr("data-action","edit"),$("#userSidebar .sidebarPanel").removeClass("open"),$("#userSidebar #addStartup").addClass("open"),$(".add-only").hide(),$(".edit-only").show();var a=$("#startupCreate"),r=$.grep(markers,function(a){return a.options.id==e})[0];console.log(r),populate(a,r.options.data),$("#logoFilename").val(r.options.data.logo.file),$("#bannerFilename").val(r.options.data.banner.file);var t=$selectizeCountry[0].selectize;t.setValue(r.options.data.country_iso);var o=$selectizeCat[0].selectize;o.setValue(r.options.data.category_id);var n=$selectizeTag[0].selectize;n.setValue(r.options.data.tags.split(","));var i=$selectizeCity[0].selectize;i.addOption({city:r.options.data.city}),i.setValue(r.options.data.city),r.options.data.logo&&($("#uploadLogoArea").css("background-image","url("+r.options.data.logo.thumb+")"),$("#uploadLogoArea").css("background-size","cover"),$("#uploadBannerArea").html("")),r.options.data.banner&&($("#uploadBannerArea").css("background-image","url("+r.options.data.banner.full+")"),$("#uploadBannerArea").css("background-size","cover"),$("#uploadLogoArea").html("")),editingItemView=!0}function populate(e,a){$.each(a,function(a,r){$("[name="+a+"]",e).val(r)})}function isLogged(){return"undefined"==typeof window.env.user||"undefined"==typeof window.env.user.uid?!1:!0}function redirect(e){window.location.replace(e)}function getURLParams(){return document.URL.substr(document.URL.indexOf("#")+1).split("/")}function loadInitialPanel(){var e=getURLParams();if(3==e.length&&"number"==typeof parseInt(e[1])){var a=$.grep(markers,function(a){return a.options.id==e[1]})[0];"object"==typeof a&&startupPanel(a.options.id)}}function buildCitiesDropdown(e){var a=[];return $.each(window.env.countryList[e].cities,function(e,r){a.push({city:r.name})}),a}var MarkerColor=[];MarkerColor[1]="blue",MarkerColor[2]="pink",MarkerColor[3]="red",MarkerColor[4]="purple",MarkerColor[5]="orange",MarkerColor[6]="green";var startupPanelClass=".startupView",geoData={},newMarker,showOptions=function(){var e=0;html="";for(x in geoData.results){var a=geoData.results[x];html+='<li><a data-geomapbox="selected-address" data-index="'+e+'" href="javascript:void(0)">'+a.formatted_address+"</a></li>",e++}$(".address_options").html(html)};