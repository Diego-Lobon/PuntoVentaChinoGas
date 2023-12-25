@extends('layouts.template')

@section('title', 'Login')

<link rel="stylesheet" href="{{ asset('css/sistema/login.css') }}">

@section('content')
    
<div class='container'>
    <div class='login-contenedor'>
        <div class="login-container_logo">
            <img src="{{ asset('css/sistema/img/icono-chinoGas.png') }}" alt="Logo-ChinoGas">
            <div class="linea"></div>
        </div>
        <div class="login-container_datos">
            <form action="{{ route('sistema.login') }}" method="POST">
                @csrf
                <div class="campo-user campos">
                    <input class='input-user' name="username" type="text" required>
                    <label class='label-user' for="">Usuario</label>
                </div>
                <div class="campo-password campos">
                    <input class='input-password' name="password" type="password" required>
                    <label class='label-password' for="">Contraseña</label>
                </div>
                <button class='btn-submit' type='submit'>INICIAR SESION</button>
            </form>
        </div>
    </div>
</div>

@endsection
