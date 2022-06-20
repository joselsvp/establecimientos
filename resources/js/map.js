document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#mapa')){
        const lat = 20.666332695977;
        const lng = -103.392177745699;

        const map = L.map('mapa').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker;

        // agregar el pin
        marker = new L.marker([lat, lng],{
             draggable: true,
             autoPan: true
        }).addTo(map);

        //detect move marker
        marker.on('moveend', function (e){
            marker = e.target
            let latitud = marker.getLatLng().lat;
            let longitud = marker.getLatLng().lng;
           console.log(latitud);
           console.log(longitud);

           //center pin automatically
            map.panTo(new L.LatLng(latitud, longitud));
        });
    }
});
