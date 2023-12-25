@extends('layouts.template')

@section('title', 'Inventario')

<link rel="stylesheet" href="{{ asset('css/sistema/crearInventario.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>INVENTARIO</h2>
            <div class="opciones">
                <a href="{{ route('sistema.inventario.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.inventario.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="form-producto">
        <h2>CREAR PRODUCTO</h2>
        <form action="{{ route('sistema.inventario.store') }}" method="POST" class="formulario" id="formulario">
            @csrf
            <div class='input-fila1'>
                <div id="grupo__nombreProducto">
                    <div>
                        <input class="formulario__input" id="nombreProducto" name="nombreProducto" type="text">
                        <label class="formulario__label" for="">Nombre del Producto</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre del producto no debe estar vacio y solo puede contener letras, espacios y pueden llevar acentos.</p>
                    <p id="formulario__input-error2" class="formulario__input-error2">Ya existe un producto con ese nombre.</p>
                </div>
                <div id="grupo__cantidad">
                    <div>
                        <input class="formulario__input" id="cantidad" name="cantidad" type="text" oninput="validarNumeroEntero(this)">
                        <label class="formulario__label" for="">Cantidad</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese la cantidad.</p>
                </div>
            </div>
            <div class="input-fila2">
                <div id="grupo__precioCompra">
                    <div>
                        <input class="formulario__input" id="precioCompra" name="precioCompra" type="text" oninput="validarNumeroReal(this)">
                        <label class="formulario__label" for="">Precio de Compra</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el precio de compra.</p>
                </div>
                <div id="grupo__precioVenta">
                    <div>
                        <input class="formulario__input" id="precioVenta" name="precioVenta" type="text" oninput="validarNumeroReal(this)">
                        <label class="formulario__label" for="">Precio de Venta</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el precio de venta.</p>
                </div>
            </div>
            <div class="formulario__mensaje" id="formulario__mensaje">
				<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
			</div>
            <div class="button-op">
                <div class="buttons">
                    <a class='btn-cancelar' href="{{ route('sistema.inventario.index') }}">CANCELAR</a>
                    <button type="submit" class='btn-crear'>
                        CREAR
                    </button>
                </div>
                <div class="formulario__mensaje-exito" id="formulario__mensaje-exito">
                    <p><i class="fa fa-check"></i> Formulario enviado exitosamente!</p>
                </div>
            </div>
        </form>
    </div>
    
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js/sistema/inventario/validarCrearInventario.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection