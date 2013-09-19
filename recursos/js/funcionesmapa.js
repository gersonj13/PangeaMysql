//MAPA
var map;
var lan = 'es';
var directionsService = new google.maps.DirectionsService();
var lati;var log;
function initialize(lat,lon) {

// Añado a Map un array con los markers que contiene
directionsDisplay = new google.maps.DirectionsRenderer();



 var myLatlng = new google.maps.LatLng(lat,lon);    
 var image = 'recursos/img/p.png';  
   
    
  


var mapOptions = {
    zoom: 14,
    center: new google.maps.LatLng(lat,lon),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    language : lan
};
map = new google.maps.Map(document.getElementById('derecha'),
    mapOptions);
	
	
  marker = new google.maps.Marker({
        map:map,
        flat:false,
        animation: google.maps.Animation.DROP,
        position: myLatlng,
        icon: image,
        title: 'Sucursal',
        zIndex: 1,
        zoom:15        
    });	

directionsDisplay.setMap(map);


             

}