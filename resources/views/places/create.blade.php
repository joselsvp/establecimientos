@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mt-4"> Registrar establecimiento</h1>

        <div class="mt-5 row justify-content-center">
            <form action="" class="col-md-9 col-xs-8 card card-body">
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
                        <select name="country_id" id="country" class="form-control m-2 @error('country') is-invalid  @enderror">
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
                        <label for="name">Dirección</label>
                        <input type="text" id="address" class="form-control m-2"
                               placeholder="Ingrese dirección">
                        <p class="text-secondary mt-5 mb-3 text-center">Se añadirá en el mapa un aproximado de la dirrección ingresada</p>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
@endsection
