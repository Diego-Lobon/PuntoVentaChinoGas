@extends('layouts.template')

@section('title', 'Ventas')

<link rel="stylesheet" href="{{ asset('css/sistema/ventas.css') }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

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
    <div class="info-inventario">
        <div class="filtros" id="filtros">
            <p>Filtros</p>  
            <div class="filtros-op">
                <div class="vendedor-op">
                    <span class='filtro-text'>Vendedor</span>
                    <select name="vendedor" id="vendedor">
                        <option value="default" selected>Seleccione</option>
                        @foreach ($vendedores as $vendedor)
                            <option value={{ $vendedor['id'] }}>{{ $vendedor['nombre'] }}</option>    
                        @endforeach
                    </select>
                </div>
                
                <div class="clientes-op">
                    <span>Tipo de Cliente</span>
                    <select name="tipoCliente" id="tipoCliente">
                        <option value="default" selected>Seleccione</option>
                        <option value="Final">Final</option>
                        <option value="Negocio">Negocio</option>
                        <option value="Punto de Venta">Punto de Venta</option>
                        <option value="Terceros">Terceros</option>
                        <option value="Almacen">Almacen</option>
                    </select>
                </div>
                
                <div class="producto-op">
                    <span>Producto</span>
                    <select name="producto" id="producto">
                        <option value="default" selected>Seleccione</option>
                        @foreach ($productos as $producto)
                            <option value={{ $producto['id'] }}>{{ $producto['nombreProducto'] }}</option>    
                        @endforeach
                    </select>
                </div>
                
                <div class="fecha-op">
                    <span>Fecha</span>
                    <input type="date" name="fecha" id="fecha">
                </div>
            </div>
        </div>
        <div class="info-balones">
            <p>Cantidad de<br>balones vendidos</p>
            <span>{{ $cantidadTotalBalones[0]->total }}</span>
        </div>
        <div class="info-ganancia">
            <p>Total de<br>Ventas</p>
            <span>S/. {{ $utilidadTotal[0]->total }}</span>
        </div>
    </div>
    <div class="container_buttons_export">
        <a href="{{ route('sistema.ventas.exportExcel') }}"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
    </div>
    <div class="table-ventas">
        <table id="table_ventas">
            <thead>
                <tr class='table-header'>
                    <td>idVenta</td>
                    <td>Nombre del<br>Cliente</td>
                    <td>Nombre del<br>Vendedor</td>
                    <td>Dirección</td>
                    <td>Celular</td>
                    <td>Cantidad</td>
                    <td>Nombre del<br>Producto</td>
                    <td>Precio<br>Unitario</td>
                    <td>Tipo de<br>Cliente</td>
                    <td>Tipo de<br>Pago</td>
                    <td>Fecha</td>
                    <td>Total</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody id="data_ventas">
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta['id'] }}</td>
                    <td>{{ $venta['nombreCliente'] }}</td>
                    <td>{{ $venta['nombreVendedor'] }}</td>
                    <td>{{ $venta['direccion'] }}</td>
                    <td>{{ $venta['celular'] }}</td>
                    <td>{{ $venta['cantidad'] }}</td>
                    <td>{{ $venta['nombreProducto'] }}</td>
                    <td>S/. {{ $venta['precioUnitario'] }}</td>
                    <td>{{ $venta['tipoCliente'] }}</td>
                    <td>{{ $venta['tipoPago'] }}</td>
                    <td>{{ $venta['created_at'] }}</td>
                    <td>S/. {{ $venta['total'] }}</td>
                    <td class="acciones_table">
                        <a href="{{ route('sistema.ventas.edit', $venta['id']) }}">
                            <button  class='btn-editar'>Editar</button>
                        </a>
                        <form action="{{ route('sistema.ventas.destroy', $venta['id']) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class='btn-delete' data-mensaje="Esta venta se eliminara definitivamente">Eliminar</button>
                        </form>
                    </td>
                </tr>    
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('js/sistema/ventas/filtroVentas.js') }}" type="module"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>

@include('layouts.alertaAcciones')

@endsection