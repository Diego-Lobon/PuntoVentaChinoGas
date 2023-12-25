@extends('layouts.template')

@section('title', 'Menu Principal')

<link rel="stylesheet" href="{{ asset('css/sistema/menuPrincipal.css') }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="menu-contenedor">
        <h1>PANEL DE ADMINISTRACION</h1>
        <div class="menu-opciones">
            <div class='opcion-inventario'>
                <a class='ventana-inventario' href="{{ route('sistema.inventario.index') }}">
                    <img src="{{ asset('css/sistema/img/icono-inventario.png') }}" alt="Icono-Inventario">
                </a>
                <a class='button-inventario button-a' href="{{ route('sistema.inventario.index') }}">
                    INVENTARIO
                </a>
            </div>
            <div class='opcion-ventas'>
                <a class='ventana-ventas' href="{{ route('sistema.ventas.index') }}">
                    <img src="{{ asset('css/sistema/img/icono-ventas.png') }}" alt="Icono-Ventas">
                </a>
                <a class='button-ventas button-a' href="{{ route('sistema.ventas.index') }}">
                    VENTAS
                </a>
            </div>
            <div class='opcion-usuarios'>
                <a class='ventana-usuarios' href="{{ route('sistema.usuarios.index') }}">
                    <img src="{{ asset('css/sistema/img/icono-usuarios.png') }}" alt="Icono-Usuarios">
                </a>
                <a class='button-usuarios button-a' href="{{ route('sistema.usuarios.index') }}">
                    USUARIOS
                </a>
            </div>
            <div class='opcion-clientes'>
                <a class='ventana-clientes' href="{{ route('sistema.clientes.index') }}">
                    <img src="{{ asset('css/sistema/img/icono-clientes.png') }}" alt="Icono-Clientes">
                </a>
                <a class='button-clientes button-a' href="{{ route('sistema.clientes.index') }}">
                    CLIENTES
                </a>
            </div>
        </div>
    </div>
</div>

@endsection