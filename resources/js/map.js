import { OpenStreetMapProvider } from 'leaflet-geosearch';
const provider = new OpenStreetMapProvider();
document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#mapa')){
        const lat = 20.666332695977;
        const lng = -103.392177745699;
        const apiKey = "AAPK5318093df0f640d68414cd313cc394bev9yQaeSRlmPH9hYprhb6ph4GOCIKFW7jpIzix6basuzTyB5rwnL3QZGthl8C5L0k";

        const map = L.map('mapa').setView([lat, lng], 16);

        //Deleter pins
        let markers = new L.featureGroup().addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker;

        // agregar el pin
        marker = new L.marker([lat, lng],{
            draggable: true,
            autoPan: true
        }).addTo(map);

        markers.addLayer(marker);

        //Geocode service
        const geocodeService =  L.esri.Geocoding.reverseGeocode({apikey: apiKey});

        //searching location in form
        const formSearchingMap = document.querySelector("#form_searching_map");

        formSearchingMap.addEventListener('blur', searchLocation);

        //detect move marker
        marker.on('moveend', function (e){
            //clear pins
            markers.clearLayers();

            marker = e.target;
            let position = marker.getLatLng();
            let latitude = position.lat;
            let longitude = position.lng;

            //center pin automatically
            centerMap(latitude, longitude)
            //Reverse Geocoding to pin relocate
            locationInMap(position)
        });

        function centerMap(latitude, longitude){
            map.panTo(new L.LatLng(latitude, longitude));
        }

        function locationInMap(position, isDynamic = false){
            geocodeService.latlng(position).run(function (error, result) {
                marker.bindPopup(result.address.LongLabel);
                marker.openPopup();

                if(isDynamic){
                    map.setView(result.latlng)
                }

                marker = new L.marker(result.latlng,{
                    draggable: true,
                    autoPan: true
                }).addTo(map);

                //new pin
                markers.addLayer(marker);

                //fill fields
                fillFields(result);
            });
        }

        function searchLocation(e){
            if(e.target.value.length > 5){
                //clear pins
                markers.clearLayers();

                provider.search({query: e.target.value}).then(result => {
                    if(result){
                        locationInMap(result[0].bounds[0], true)
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        }

        function fillFields(result){
            document.querySelector("#address").value = result.address.Address || '';
            document.querySelector("#neighborhood").value = result.address.Neighborhood || '';
            document.querySelector("#country").value = result.address.CntryName || '';
            document.querySelector("#postal_code").value = result.address.Postal || '';
            document.querySelector("#latitude").value = result.latlng.lat || '';
            document.querySelector("#longitude").value = result.latlng.lng || '';
        }
    }
});
