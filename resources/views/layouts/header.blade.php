<link rel="stylesheet" href="{{ asset('css/layouts/header.css') }}">

<div class='header'>
    <div class='info-usuario'>
        <img src="{{ asset('css/sistema/img/icono-usuario.png') }}" alt="Icono-Usuario">
        @auth
            <span>Bienvenido {{ auth()->user()->username }} | {{ auth()->user()->rol }}</span>
        @endauth
    </div>
    <div class="cerrarSesion">
        <img src="{{ asset('css/sistema/img/icono-cerrarSesion.png') }}" alt="Icono-CerrarSesion">
        <a href="{{ route('sistema.logout') }}"><button>Cerrar Sesión</button></a>
    </div>
</div>