@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"/>
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-4"> Registrar establecimiento</h1>

        <div class="mt-5 row justify-content-center">
            <form method="POST" action="{{route('establecimiento.store')}}" class="col-md-9 col-xs-8 card card-body" enctype="multipart/form-data">
                @csrf
                <fieldset class="border p-4">
                    <legend class="text-primary">Completa la información de tu establecimiento</legend>
                    <div class="form-group">
                        <label for="name">Nombre de establecimiento</label>
                        <input type="text" id="name" class="form-control m-2 @error('name') is-invalid @enderror"
                               placeholder="Ingrese nombre de establecimiento" name="name" value="{{old('name')}}">

                        @error('name')
                            <div class="invalid-feeback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <select name="category_id" id="category" class="form-control m-2 @error('category') is-invalid  @enderror">
                            <option value="" selected disabled>-- Seleccione una categoría --</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="invalid-feeback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Imagen</label>
                        <input type="file" id="image" class="form-control m-2 @error('image') is-invalid @enderror"
                               name="image" value="{{old('image')}}">

                        @error('image')
                        <div class="invalid-feeback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">País</label>
                        <select name="country" id="country" class="form-control m-2 @error('country') is-invalid  @enderror">
                            <option value="" selected disabled>-- Seleccione un país --</option>
                            <option value="1">México</option>
                        </select>
                        @error('country')
                        <div class="invalid-feeback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="form_searching_map">Ubica tu establecimiento en el mapa</label>
                        <input type="text" id="form_searching_map" name="address" class="form-control m-2" placeholder="Ingrese dirección">
                        <p class="text-secondary mt-5 mb-3 text-center">Se añadirá en el mapa un aproximado de la dirrección ingresada</p>
                    </div>

                    <div class="form-group">
                        <div id="mapa" style="height: 400px"></div>
                    </div>
                    <p class="information"> Confirma que los siguientes campos son correctos</p>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" id="address" class="form-control @error('address') is-invalid @enderror">
                    </div>

                    <input type="submit" value="Guardar" class="btn btn-success">
                </fieldset>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet" defer></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(document.querySelector('#mapa')){
                const lat = 20.666332695977;
                const lng = -103.392177745699;
                const apiKey = "{{env('API_KEY_ESRI_LEAFLET')}}";

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

                //Geocode service
                const geocodeService =  L.esri.Geocoding.reverseGeocode({apikey: apiKey});

                //detect move marker
                marker.on('moveend', function (e){
                    marker = e.target;
                    let position = marker.getLatLng();
                    let latitud = position.lat;
                    let longitud = position.lng;
                    console.log(latitud);
                    console.log(longitud);

                    //center pin automatically
                    map.panTo(new L.LatLng(latitud, longitud));

                    //Reverse Geocoding to pin relocate

                    geocodeService.latlng(position).run(function (error, result) {
                        console.log(result.address);
                        marker.bindPopup(result.address.LongLabel);
                        marker.openPopup();
                    });

                });
            }
        });
    </script>
@endsection()
