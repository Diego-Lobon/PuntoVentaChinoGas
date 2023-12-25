@extends('layouts.template')

@section('title', 'Usuarios')

<link rel="stylesheet" href="{{ asset('css/sistema/usuarios.css') }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>USUARIOS</h2>
            <div class="opciones">
                <a href="{{ route('sistema.usuarios.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.usuarios.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="table-usuarios">
        <table>
            <thead>
                <tr class='table-header'>
                    <td>idUsuario</td>
                    <td>Username</td>
                    <td>Nombre de Usuario</td>
                    <td>Contraseña</td>
                    <td>Tipo de Usuario</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario['id'] }}</td>
                    <td>{{ $usuario['username'] }}</td>
                    <td>{{ $usuario['nombre'] }}</td>
                    <td>{{ $usuario['password'] }}</td>
                    <td>{{ $usuario['rol'] }}</td>
                    <td class="acciones_table">
                        <a href="{{ route('sistema.usuarios.edit', $usuario['id']) }}">
                            <button  class='btn-editar'>Editar</button>
                        </a>
                        <form action="{{ route('sistema.usuarios.destroy', $usuario['id']) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class='btn-delete' data-mensaje="Este usuario se eliminara definitivamente">Eliminar</button>
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
