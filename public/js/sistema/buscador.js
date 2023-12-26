$('#buscador').keyup(function() {
    
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('https://puntoventachinogas-production.up.railway.app/ventas/crear', {
            method: 'POST',
            body: JSON.stringify({inputValue: $(this).val()}),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            const container = document.getElementById("container_buscador")
            container.classList.remove("container_buscador")
            container.classList.add("container_buscador_encontrado")
            if(data.respuesta != 'No se encontró ningún cliente'){

                console.log(data.respuesta.length);

                var ul = "";
                
                                        
                for(var i=0; i < data.respuesta.length; i++){
                                                           
                    ul = ul + '<li class="li_encontrado opcion_li"><i class="fas fa-search"></i>'+data.respuesta[i]['nombreCliente']+'</li>';
                         

                }

                            
                $('#resultados').html(ul);


            }
            else {

                if($(this).val() == ""){

                    /*const container = document.getElementById("container_buscador_encontrado")
                    container.classList.remove("container_buscador_encontrado")
                    container.classList.add("container_buscador")*/

                }

                let ul = "";
   
                ul+='<li class="li_encontrado">No hay resultados</li>';
                            
                $('#resultados').html(ul);

            }
            
        })
        .catch(error => console.error(error));
    

});


$('#buscador').blur(function() {

    setTimeout(function() {
        // Aquí se encuentra el código del evento blur

        let ul = "";

        const container = document.getElementById("container_buscador")
        container.classList.remove("container_buscador_encontrado")
        container.classList.add("container_buscador")

        $('#resultados').html(ul);

        // ... Tu código aquí ...
      }, 200);
    

})

$(document).on('click', '.opcion_li', function(){
    const container = document.getElementById("container_buscador");
    container.classList.remove("container_buscador_encontrado");
    container.classList.add("container_buscador");
    const input = document.getElementById('buscador');
    input.value = $(this).text();
});




$('#btn_cargar_datos').click(function() {
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const input = document.getElementById('buscador')

    fetch('http://127.0.0.1:8000/ventas/crear/datosCliente', {
        method: 'POST',
        body: JSON.stringify({inputValue: input.value}),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        
        console.log(data)

        if(data.respuesta != 'No se encontró ningún cliente'){

            document.getElementById('idCliente').value = data.respuesta[0]['id'];
            document.getElementById('nombreCliente').value = data.respuesta[0]['nombreCliente'];
            document.getElementById('direccion').value = data.respuesta[0]['direccion'];
            document.getElementById('celular').value = data.respuesta[0]['celular'];

            document.getElementById('nombreCliente').disabled = true;
            document.getElementById('direccion').disabled = true;
            document.getElementById('celular').disabled = true;
            document.getElementById('select_tipo_cliente').disabled = true;

            document.getElementById('nombreCliente').classList.add('disable')
            document.getElementById('direccion').classList.add('disable')
            document.getElementById('celular').classList.add('disable')
            document.getElementById('select_tipo_cliente').classList.add('disable')

            document.getElementById('btn_quitar_datos').classList.remove('btn_quitar_datos')
            document.getElementById('btn_quitar_datos').classList.add('btn_quitar_datos_active')

            document.getElementById('btn_quitar_datos').disabled = false;

            const select = document.getElementById('select_tipo_cliente');
            
            for (let i = 0; i < select.options.length; i++) {
                console.log(select.options[i].value)
                
                if (select.options[i].value == data.respuesta[0]['tipo']) {
                    
                    select.selectedIndex = i;
                    break;
                }
            }

        }

        
        

        
    })
    .catch(error => console.error(error));


});


$('#btn_quitar_datos').click(function() {

    document.getElementById('buscador').value = "";

    document.getElementById('idCliente').value = "";
    document.getElementById('nombreCliente').value = "";
    document.getElementById('direccion').value = "";
    document.getElementById('celular').value = "";
    document.getElementById('select_tipo_cliente').selectedIndex = [0]

    document.getElementById('nombreCliente').disabled = false;
    document.getElementById('direccion').disabled = false;
    document.getElementById('celular').disabled = false;
    document.getElementById('select_tipo_cliente').disabled = false;

    document.getElementById('nombreCliente').classList.remove('disable')
    document.getElementById('direccion').classList.remove('disable')
    document.getElementById('celular').classList.remove('disable')
    document.getElementById('select_tipo_cliente').classList.remove('disable')

    document.getElementById('btn_quitar_datos').classList.add('btn_quitar_datos')
    document.getElementById('btn_quitar_datos').classList.remove('btn_quitar_datos_active')

    document.getElementById('btn_quitar_datos').disabled = true;

});

document.addEventListener('DOMContentLoaded', function() {
    // Hacer una petición GET a la ruta de Laravel
    fetch('/cargar-datos-select')
        .then(response => response.json())
        .then(data => {
            // Obtener el select y llenarlo con los datos obtenidos
            const select = document.getElementById('select_tipo_cliente');
            const options = select.options;
            for (const key in data) {
                // Verificar si la opción ya existe en el select
                let optionExists = false;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value == key) {
                        optionExists = true;
                        break;
                    }
                }
                // Agregar la opción solo si no existe
                if (!optionExists) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.text = data[key];
                    select.add(option);
                }
            }
        });
});
