@extends('layouts.template')

@section('title', 'Inventario')

<link rel="stylesheet" href="{{ asset('css/sistema/inventario.css') }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

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
    <div class="info-inventario">
        <div class="info-balones">
            <p>Cantidad de<br>balones</p>
            <span>{{ $cantidadTotalBalones[0]->total }}</span>
        </div>
        <div class="info-ganancia">
            <p>Total de<br>ganancias</p>
            <span>S/. {{ $utilidadTotal[0]->total }}</span>
        </div>
    </div>
    <div class="table-inventario">
        <table>
            <thead>
                <tr class='table-header'>
                    <td>idProducto</td>
                    <td>Nombre del Producto</td>
                    <td>Cantidad</td>
                    <td>Precio de Compra</td>
                    <td>Precio de Venta</td>
                    <td>Ingresos Totales</td>
                    <td>Costos Totales</td>
                    <td>Utilidad</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto['id'] }}</td>
                    <td>{{ $producto['nombreProducto'] }}</td>
                    <td>{{ $producto['cantidad'] }}</td>
                    <td>S/. {{ $producto['precioCompra'] }}</td>
                    <td>S/. {{ $producto['precioVenta'] }}</td>
                    <td>S/. {{ $producto['ingresosTotales'] }}</td>
                    <td>S/. {{ $producto['costosTotales'] }}</td>
                    <td>S/. {{ $producto['utilidad'] }}</td>
                    <td class="acciones_table">
                        <a href="{{ route('sistema.inventario.edit', $producto['id'] ) }}">
                            <button  class='btn-editar'>Editar</button>
                        </a>
                        <form class="form-eliminar" action="{{ route('sistema.inventario.destroy', $producto['id']) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class='btn-delete' data-mensaje="Este producto se eliminara definitivamente">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</div>

@include('layouts.alertaAcciones')

@endsection