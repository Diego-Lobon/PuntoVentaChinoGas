@extends('layouts.template')

@section('title', 'Inventario')

<link rel="stylesheet" href="{{ asset('css/sistema/crearVentas.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>VENTAS</h2>
            <div class="opciones">
                <a href="{{ route('sistema.ventas.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.ventas.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="form-ventas">
        <h2>CREAR VENTA</h2>
        <div class="container_buscar">
            <div class="container_buscador" id="container_buscador">
                <input type="text" name="buscador" id="buscador" placeholder="Buscar" autocomplete="off">
                <ul class="resultados" id="resultados">

                </ul>
            </div>
            <button class="btn_cargar_datos" id="btn_cargar_datos"><i class="fas fa-upload"></i> Cargar Cliente</button>
            <button class="btn_quitar_datos" id="btn_quitar_datos" disabled><i class="fas fa-upload"></i> Quitar Cliente</button>

        </div>
        <form action="{{ route('sistema.ventas.store') }}" method="POST" class="formulario" id="formulario">
            @csrf
            <input type="text" id="idCliente" name="idCliente" hidden>
            <div class='input-fila1'>
                <div id="grupo__nombreCliente">
                    <div>
                        <input class="formulario__input" type="text" id="nombreCliente" name="nombreCliente">
                        <label class="formulario__label" for="">Nombre del Cliente</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre del cliente tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
                    <p id="formulario__input-error2" class="formulario__input-error2">Ya existe un cliente con ese nombre.</p>
                </div>
                <div id="grupo__select_vendedor">
                    <div>
                        <select name="select_vendedor" id="select_vendedor">
                            <option value="default" selected>Seleccione vendedor</option>
                            @foreach ($vendedores as $vendedor)
                            <option value={{ $vendedor['id'] }}>{{ $vendedor['nombre'] }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un vendedor.</p>
                </div>
                <div id="grupo__direccion">
                    <div>
                        <input class="formulario__input" type="text" id="direccion" name="direccion">
                        <label class="formulario__label" for="">Direccion</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p id="validar_password" class="formulario__input-error">Ingrese la dirección.</p>
                </div>
            </div>
            <div class="input-fila2">
                <div id="grupo__celular">
                    <div>
                        <input class="formulario__input" type="text" id="celular" name="celular">
                        <label class="formulario__label" for="">Celular</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el celular de 9 digitos, solo ingrese numeros.</p>
                </div>
                <div id="grupo__cantidad">
                    <div>
                        <input class="formulario__input" type="text" id="cantidad" name="cantidad" oninput="validarNumeroEntero(this)" >
                        <label class="formulario__label" for="">Cantidad</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese la cantidad.</p>
                </div>
                <div id="grupo__select_producto">
                    <div >
                        <select name="select_producto" id="select_producto">
                            <option value="default" selected>Seleccione producto</option>
                            @foreach ($productos as $producto)
                            <option value={{ $producto['id'] }}>{{ $producto['nombreProducto'] }}</option>    
                            @endforeach
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un producto.</p>
                </div>
            </div>
            <div class="input-fila3">
                <div id="grupo__select_tipo_cliente">
                    <div>
                        <select name="select_tipo_cliente" id="select_tipo_cliente">
                            <option value="default" selected>Seleccione Tipo de Cliente</option>
                            <option value="Final">Final</option>
                            <option value="Negocio">Negocio</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                            <option value="Terceros">Terceros</option>
                            <option value="Almacen">Almacen</option>
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un tipo de cliente.</p>
                </div>
                <div id="grupo__select_tipo_pago">
                    <div>
                        <select name="select_tipo_pago" id="select_tipo_pago">
                            <option value="default" selected>Seleccione Tipo de Pago</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Yape">Yape</option>Credito
                            <option value="Transferencia">Transferencia</option>
                            <option value="Credito">Credito</option>
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un tipo de pago.</p>
                </div>
                
            </div>
            <div class="formulario__mensaje" id="formulario__mensaje">
				<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
			</div>
            <div class="button-op">
                <div class="buttons">
                    <a class='btn-cancelar' href="{{ route('sistema.ventas.index') }}">CANCELAR</a>
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
<script src="{{ asset('js/sistema/buscador.js') }}"></script>
<script src="{{ asset('js/sistema/ventas/validarCrearVenta.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection