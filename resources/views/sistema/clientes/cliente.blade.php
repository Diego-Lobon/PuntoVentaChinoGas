@extends('layouts.template')

@section('title', 'Clientes')

<link rel="stylesheet" href="{{ asset('css/sistema/clientes.css') }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>CLIENTES</h2>
            <div class="opciones">
                <a href="{{ route('sistema.clientes.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.clientes.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="info-clientes">
        <div class="filtros">
            <p>Filtros</p>  
            <div class="filtros-op">
                <div class="cliente-op">
                    <span class='filtro-text'>Tipo de Cliente</span>
                    <select name="tipo" id="tipo">
                        <option value="Todos los tipos" selected>Todos los tipos</option>
                        <option value="Final">Final</option>
                        <option value="Negocio">Negocio</option>
                        <option value="Punto de Venta">Punto de Venta</option>
                        <option value="Terceros">Terceros</option>
                        <option value="Almacen">Almacen</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="table-clientes">
        <table id="table_clientes">
            <thead>
                <tr class='table-header'>
                    <td>idCliente</td>
                    <td>Nombre del Cliente</td>
                    <td>Dirección</td>
                    <td>Celular</td>
                    <td>Tipo de Cliente</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody id="data_clientes">
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente['id'] }} </td>
                    <td>{{ $cliente['nombreCliente'] }} </td>
                    <td>{{ $cliente['direccion'] }} </td>
                    <td>{{ $cliente['celular'] }} </td>
                    <td>{{ $cliente['tipo'] }} </td>
                    <td class="acciones_table">
                        <a href="{{ route('sistema.clientes.edit', $cliente['id'] ) }}">
                            <button class='btn-editar'>Editar</button>
                        </a>
                        <form class="form-eliminar" action="{{ route('sistema.clientes.destroy', $cliente['id'] ) }} " method="POST" >
                            @csrf
                            @method('delete')
                            <button type="submit" class='btn-delete' data-mensaje="Este cliente se eliminara definitivamente">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/sistema/clientes/filtroCliente.js') }}" type="module"></script>
@include('layouts.alertaAcciones')

@endsection
