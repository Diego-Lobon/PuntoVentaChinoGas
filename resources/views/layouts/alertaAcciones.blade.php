<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/sistema/alertaAccion.js') }}"></script>

@if(session('eliminar') == 'ok')
    <script>
        var mensaje = '{{ session('dato') }}';
        Swal.fire(
            '¡Eliminado!',
            mensaje,
            'success'
        )
    </script>
@endif