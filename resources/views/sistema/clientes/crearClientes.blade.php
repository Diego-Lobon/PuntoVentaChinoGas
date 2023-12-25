@extends('layouts.template')

@section('title', 'Clientes')

<link rel="stylesheet" href="{{ asset('css/sistema/crearClientes.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>CLIENTE</h2>
            <div class="opciones">
                <a href="{{ route('sistema.clientes.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.clientes.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="form-clientes">
        <h2>CREAR CLIENTE</h2>
        <form action="{{ route('sistema.clientes.store') }}" method="POST" class="formulario" id="formulario">
            @csrf
            <div class='input-fila1'>
                <div id="grupo__nombreCliente">
                    <div>
                        <input class="formulario__input" id="nombreCliente" name="nombreCliente" type="text">
                        <label class="formulario__label" for="">Nombre deL Cliente</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre del cliente tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
                    <p id="formulario__input-error2" class="formulario__input-error2">Ya existe un cliente con ese nombre.</p>
                </div> 
            </div>
            <div class="input-fila2">
                <div id="grupo__direccion">
                    <div>
                        <input class="formulario__input" id="direccion" name="direccion" type="text">
                        <label class="formulario__label" for="">Dirección</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p id="validar_password" class="formulario__input-error">Ingrese la dirección.</p>
                </div>
            </div>
            <div class="input-fila3">
                <div id="grupo__celular">
                    <div>
                        <input class="formulario__input" id="celular" name="celular" type="text" oninput="validarNumeroEntero(this)">
                        <label class="formulario__label" for="">Celular</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el celular de 9 digitos, solo ingrese numeros.</p>
                </div>
            </div>
            <div class="input-fila4">
                <div id="grupo__tipo">
                    <div>
                        <select class="formulario__select" name="tipo" id="tipo">
                            <option value="default" selected>Seleccion un Tipo</option>
                            <option value="Final">Final</option>
                            <option value="Negocio">Negocio</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                            <option value="Terceros">Terceros</option>
                            <option value="Almacen">Almacen</option>
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un tipo de cliente.</p>
                </div>
            </div>
            <div class="formulario__mensaje" id="formulario__mensaje">
				<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
			</div>
            <div class="button-op">
                <div class="buttons">
                    <a class='btn-cancelar' href="{{ route('sistema.clientes.index') }}">CANCELAR</a>
                    <button type="submit" class='btn-crear'>
                        CREAR
                    </button>
                </div>
                
                <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
            </div>

        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js/sistema/clientes/validarCrearCliente.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection

