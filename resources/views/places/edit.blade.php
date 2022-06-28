@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"/>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <select name="category_id" id="category_id" class="form-control m-2 @error('category_id') is-invalid  @enderror">
                            <option value="" selected disabled>-- Seleccione una categoría --</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen</label>
                        <input type="file" id="image" name="image"class="form-control m-2 @error('image') is-invalid @enderror"
                               value="{{old('image')}}">

                        @error('image')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="form_searching_map">Ubica tu establecimiento en el mapa</label>
                        <input type="text" id="form_searching_map" class="form-control m-2" placeholder="Ingrese dirección">
                        <p class="text-secondary mt-5 mb-3 text-center">Se añadirá en el mapa un aproximado de la dirrección ingresada</p>
                    </div>

                    <div class="form-group">
                        <div id="mapa" style="height: 400px"></div>
                    </div>
                    <p class="information"> Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="category">País</label>
                        <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror">
                        @error('country')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Calle</label>
                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror">
                        @error('address')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="neighborhood">Colonia</label>
                        <input type="text" id="neighborhood" name="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror">
                        @error('neighborhood')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Código Postal</label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror">
                        @error('postal_code')
                        <div class="text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <fieldset class="border p-4 mt-5">
                        <legend  class="text-primary">Información Establecimiento: </legend>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input
                                type="tel"
                                class="form-control @error('phone')  is-invalid  @enderror"
                                id="phone"
                                placeholder="Teléfono Establecimiento"
                                name="phone"
                                value="{{ old('phone') }}"
                            >

                            @error('phone')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea
                                class="form-control  @error('description')  is-invalid  @enderror"
                                name="description"
                            >{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="opening">Hora Apertura:</label>
                            <input
                                type="time"
                                class="form-control @error('opening')  is-invalid  @enderror"
                                id="opening"
                                name="opening"
                                value="{{ old('opening') }}"
                            >
                            @error('opening')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="close">Hora de cierre:</label>
                            <input
                                type="time"
                                class="form-control @error('close')  is-invalid  @enderror"
                                id="close"
                                name="close"
                                value="{{ old('close') }}"
                            >
                            @error('close')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </fieldset>
                    <fieldset class="border p-4 mt-5">
                        <legend  class="text-primary">Información adicional: </legend>
                        <div class="form-group">
                            <label for="">Imágenes</label>
                            <div id="dropzone" class="dropzone form-control"></div>
                        </div>
                    </fieldset>

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="uuid" id="uuid" value="{{\Illuminate\Support\Str::uuid()->toString()}}">

                    <input type="submit" value="Guardar" class="btn btn-primary mt-3 d-block" style="width: 100%">
                </fieldset>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet" defer></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" defer></script>
@endsection()
