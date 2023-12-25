@extends('layouts.template')

@section('title', 'Inventario')

<link rel="stylesheet" href="{{ asset('css/sistema/crearUsuarios.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@extends('layouts.header')

<div class="container">
    <div class="nav-menu">
        <div class='nav-menu_opciones'>
            <h2>INVENTARIO</h2>
            <div class="opciones">
                <a href="{{ route('sistema.usuarios.index') }}" class='button-nav'>Home</a>
                <a href="{{ route('sistema.usuarios.create') }}" class='button-nav'>Crear</a>
            </div>
        </div>
        <a class='button-regresar' href="{{ route('sistema.menuPrincipal') }}">Regresar</a>
    </div>
    <div class="form-usuarios">
        <h2>CREAR USUARIO</h2>
        <form action="{{ route('sistema.usuarios.store') }}" method="POST" class="formulario" id="formulario">
            @csrf
            <div class='input-fila1'>
                <div id="grupo__username">
                    <div>
                        <input class="formulario__input" id="username" name="username" type="text">
                        <label class="formulario__label" for="">Nombre de Usuario</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El username tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras, guion bajo y no debe estar vacio.</p>
                    <p id="formulario__input-error2" class="formulario__input-error2">Ya existe un cliente con ese nombre.</p>
                </div> 
            </div>
            <div class='input-fila2'>
                <div id="grupo__nombreUsuario">
                    <div>
                        <input class="formulario__input" id="nombreUsuario" name="nombreUsuario" type="text">
                        <label class="formulario__label" for="">Nombre</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ingrese el nombre de usuario, el nombre de usuario puede contener letras y espacios, pueden llevar acentos.</p>
                </div> 
            </div>
            <div class="input-fila3">
                <div id="grupo__password">
                    <div>
                        <input class="formulario__input" id="password" name="password" type="password">
                        <label class="formulario__label" for="">Contraseña</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p id="validar_password" class="formulario__input-error">La contraseña tiene que ser de 4 a 12 dígitos y no puede comenzar con espacio.</p>
                </div>
            </div>
            <div class="input-fila4">
                <div id="grupo__password_confirmation">
                    <div>
                        <input class="formulario__input" id="password_confirmation" name="password_confirmation" type="password">
                        <label class="formulario__label" for="">Repetir Contraseña</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Ambas contraseñas deben ser iguales.</p>
                    <p id="validar_password2" class="formulario__input-error2">Primero escriba la contraseña para verificar si son iguales.</p>
                    <p class="formulario__input-error3">Verifique si el campo contraseña esta correcto.</p>
                </div>
            </div>
            <div class="input-fila5">
                <div id="grupo__rol">
                    <div>
                        <input class="formulario__input" id="rol" name="rol" type="text">
                        <label class="formulario__label" for="">Tipo de Usuario</label>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El tipo de usuario solo puede llevar letras, espacios, acentos y no debe estar vacio.</p>
                </div>
            </div>
            <div class="formulario__mensaje" id="formulario__mensaje">
				<p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
			</div>
            <div class="button-op">
                <div class="buttons">
                    <a class='btn-cancelar' href="{{ route('sistema.usuarios.index') }}">CANCELAR</a>
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
<script src="{{ asset('js/sistema/usuarios/validarCrearUsuario.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection

