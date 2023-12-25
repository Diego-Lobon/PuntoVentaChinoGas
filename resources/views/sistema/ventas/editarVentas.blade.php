@extends('layouts.template')

@section('title', 'Inventario')

<link rel="stylesheet" href="{{ asset('css/sistema/crearVentas.css') }}">

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
        <h2>EDITAR VENTA</h2>
        <div class="info_id">
            <span>ID Venta: {{ $venta[0]['id'] }}</span>
            <input id='idElemento' class='idElemento' value='{{ $venta[0]['id'] }}'>
        </div>
        <form action="{{ route('sistema.ventas.update', $venta[0]['id']) }}" method="POST" class="formulario" id="formulario">
            @csrf
            @method('put')
            <input type="text" id="idCliente" name="idCliente" value="{{ $venta[0]['idCliente'] }}" hidden>
            <div class='input-fila1'>
                <div id="grupo__nombreCliente">
                    <div>
                        <input class="formulario__input" type="text" id="nombreCliente" name="nombreCliente" value="{{ $venta[0]['nombreCliente'] }}">
                        <label class="formulario__label" for="">Nombre del Cliente</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre del cliente tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
                    <p id="formulario__input-error2" class="formulario__input-error2">Ya existe un cliente con ese nombre.</p>
                </div>
                <div id="grupo__select_vendedor">
                    <div>
                        <select name="select_vendedor" id="select_vendedor">
                            <option value="default" @if ($venta[0]['nombreVendedor'] == 'default') selected @endif>Seleccione vendedor</option>
                            @foreach ($vendedores as $vendedor)
                            <option value="{{ $vendedor['id'] }}" @if ($venta[0]['nombreVendedor'] == $vendedor['nombre']) selected @endif>{{ $vendedor['nombre'] }}</option>                            
                            @endforeach
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un vendedor.</p>
                </div>
                <div id="grupo__direccion">
                    <div>
                        <input class="formulario__input" type="text" id="direccion" name="direccion" value="{{ $venta[0]['direccion'] }}">
                        <label class="formulario__label" for="">Direccion</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p id="validar_password" class="formulario__input-error">Ingrese la dirección.</p>
                </div>
            </div>
            <div class="input-fila2">
                <div id="grupo__celular">
                    <div>
                        <input class="formulario__input" type="text" id="celular" name="celular" value="{{ $venta[0]['celular'] }}">
                        <label class="formulario__label" for="">Celular</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el celular de 9 digitos, solo ingrese numeros.</p>
                </div>
                <div id="grupo__cantidad">
                    <div>
                        <input class="formulario__input" type="text" id="cantidad" name="cantidad" oninput="validarNumeroEntero(this)" value="{{ $venta[0]['cantidad'] }}">
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
                            <option value={{ $producto['id'] }} @if ($venta[0]['nombreProducto'] == $producto['nombreProducto']) selected @endif>{{ $producto['nombreProducto'] }}</option>    
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
                            <option value="default" @if ($venta[0]['tipoCliente'] == 'default') selected @endif>Seleccione Tipo de Cliente</option>
                            <option value="Final" @if ($venta[0]['tipoCliente'] == 'Final') selected @endif>Final</option>
                            <option value="Negocio" @if ($venta[0]['tipoCliente'] == 'Negocio') selected @endif>Negocio</option>
                            <option value="Punto de Venta" @if ($venta[0]['tipoCliente'] == 'Punto de Venta') selected @endif>Punto de Venta</option>
                            <option value="Terceros" @if ($venta[0]['tipoCliente'] == 'Terceros') selected @endif>Terceros</option>
                            <option value="Almacen" @if ($venta[0]['tipoCliente'] == 'Almacen') selected @endif>Almacen</option>
                        </select>
                    </div>
                    <p class="formulario__input-error">Seleccione un tipo de cliente.</p>
                </div>
                <div id="grupo__select_tipo_pago">
                    <div>
                        <select name="select_tipo_pago" id="select_tipo_pago">
                            <option value="default" @if ($venta[0]['tipoPago'] == 'default') selected @endif>Seleccione Tipo de Pago</option>
                            <option value="Efectivo" @if ($venta[0]['tipoPago'] == 'Efectivo') selected @endif>Efectivo</option>
                            <option value="Yape" @if ($venta[0]['tipoPago'] == 'Yape') selected @endif>Yape</option>Credito
                            <option value="Transferencia" @if ($venta[0]['tipoPago'] == 'Transferencia') selected @endif>Transferencia</option>
                            <option value="Credito" @if ($venta[0]['tipoPago'] == 'Credito') selected @endif>Credito</option>
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
                        GUARDAR
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
<script src="{{ asset('js/sistema/ventas/validarEditarVenta.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection