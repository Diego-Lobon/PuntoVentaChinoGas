const formulario = document.getElementById('formulario')
const inputs = document.querySelectorAll("#formulario input");

const expresiones = {
	nombre: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/, // Letras y espacios, pueden llevar acentos.
    cantidad: /^\d{1,10000}$/, 
    precio: /^(?!\.)[^]{1,99999999}$/,
}

const campos = {
    nombreProducto: false,
    cantidad: false,
    precioCompra: false,
    precioVenta: false,
}

/* VALIDACION PARA NO CREAR UN PRODUCTO REPETIDO CON MISMO NOMBRE */ 

function enviarValor(inputValue, input) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const idProducto = document.getElementById('idElemento');
    fetch('https://puntoventachinogas-production.up.railway.app/inventario/'+idProducto.value+'/editar', {
        method: 'POST',
        body: JSON.stringify({inputValue: inputValue, idProducto: idProducto.value}),
        headers: {
            'Content-Type': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data != 1){
            document.getElementById(`grupo__nombreProducto`).classList.remove('formulario__grupo-incorrecto')
            document.getElementById(`grupo__nombreProducto`).classList.add('formulario__grupo-correcto')
            document.querySelector(`#grupo__nombreProducto i`).classList.add('fa-check-circle')
            document.querySelector(`#grupo__nombreProducto i`).classList.remove('fa-times-circle')
            document.querySelector(`#grupo__nombreProducto .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            campos[nombreProducto] = true
        }
        else {
            document.getElementById(`grupo__nombreProducto`).classList.add('formulario__grupo-incorrecto')
            document.getElementById(`grupo__nombreProducto`).classList.remove('formulario__grupo-correcto')
            document.querySelector(`#grupo__nombreProducto i`).classList.add('fa-times-circle')
            document.querySelector(`#grupo__nombreProducto i`).classList.remove('fa-check-circle')
            document.querySelector(`#grupo__nombreProducto .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__nombreProducto .formulario__input-error2`).classList.add('formulario__input-error-activo')
            campos[nombreProducto] = false
        }
        const mensaje = document.querySelector('#formulario__input-error2')
        if(!mensaje.classList.contains('formulario__input-error-activo')){
            console.log("entro")
            document.querySelector(`#grupo__nombreProducto .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            validarCampo(expresiones.nombre, input, 'nombreProducto')
        }
        
      // Aquí se maneja la respuesta de Laravel
    })
    .catch(error => console.error(error));
  }

/************************************************************/

const validarFormulario = (e) => {
        switch (e.target.name) {
            case "nombreProducto":
                if (e.target.value.trim() == "") {
                    document.querySelector(`#grupo__nombreProducto .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                    validarCampo(expresiones.nombre, e.target, 'nombreProducto')
                } else {
                    document.querySelector(`#grupo__nombreProducto .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    enviarValor(e.target.value, e.target);
                }    
            break;
            case "cantidad":
                validarCampo(expresiones.cantidad, e.target, 'cantidad')
            break;
            case "precioCompra":
                validarCampo(expresiones.precio, e.target, 'precioCompra')
            break;
            case "precioVenta":
                validarCampo(expresiones.precio, e.target, 'precioVenta')
            break;
        }    
}

const validarCampo = (expresion, input, campo) => {
    
    if(expresion.test(input.value)){
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto')
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto')
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle')
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle')
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo')
        campos[campo] = true
    }
    else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto')
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto')
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle')
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle')
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo')
        campos[campo] = false
    }

}


const input = document.getElementById("nombreProducto");
let borrarPresionado = false;

input.addEventListener("input", function() {
  if (input.value !== "") {
    console.log('nada')
  } else {
    mostrarMensaje();
  }
});

input.addEventListener("keydown", function(event) {
  if (event.key === "Backspace" || event.key === "Delete") {
    borrarPresionado = true;
    if (input.value === "") {
      mostrarMensaje();
    }
  }
});

input.addEventListener("keyup", function(event) {
  if (event.key === "Backspace" || event.key === "Delete") {
    borrarPresionado = false;
  }
});

input.addEventListener("blur", function() {
  if (borrarPresionado && input.value === "") {
    mostrarMensaje();
  }
});

function mostrarMensaje() {
  const input = document.getElementById("nombreProducto");
  document.querySelector(`#grupo__nombreProducto .formulario__input-error2`).classList.remove('formulario__input-error-activo')
  validarCampo(expresiones.nombre, input, 'nombreProducto')
}

const inputNombreProducto = document.querySelector('#nombreProducto')
const inputCantidad = document.querySelector('#cantidad')
const inputPrecioCompra = document.querySelector('#precioCompra')
const inputPrecioVenta = document.querySelector('#precioVenta')

validarCampo(expresiones.nombre, inputNombreProducto, 'nombreProducto')
inputNombreProducto.classList.add("inputFocusActived");

validarCampo(expresiones.cantidad, inputCantidad, 'cantidad')
inputCantidad.classList.add("inputFocusActived");

validarCampo(expresiones.precio, inputPrecioCompra, 'precioCompra')
inputPrecioCompra.classList.add("inputFocusActived");

validarCampo(expresiones.precio, inputPrecioVenta, 'precioVenta')
inputPrecioVenta.classList.add("inputFocusActived");


inputs.forEach((input) => {

    input.addEventListener('focus', ()=>{
        if(!input.classList.contains('inputFocusActived')){
            input.classList.add("inputFocusActived");
        }
    })

        
    input.addEventListener('blur', ()=>{
        if(input.value == "" ){
            input.classList.remove('inputFocusActived');
        }

    })

    input.addEventListener('keyup', validarFormulario)
    input.addEventListener('blur', validarFormulario)
    
})

function validarNumeroEntero(input) {
    // Permitir solo números y un punto decimal
    input.value = input.value.replace(/[^0-9]/g, '');
    // Permitir solo un punto decimal
    const parts = input.value.split('.');
    if (parts.length > 2) {
      input.value = parts[0] + '.' + parts.slice(1).join('');
    }
}

function validarNumeroReal(input) {
    // Permitir solo números y un punto decimal
    input.value = input.value.replace(/[^0-9.]/g, '');
  
    // Permitir solo un punto decimal
    const parts = input.value.split('.');
    if (parts.length > 2) {
      input.value = parts[0] + '.' + parts.slice(1).join('');
    }
}

formulario.addEventListener('submit', (e) => {
    

    if(campos.nombreProducto && campos.cantidad && campos.precioCompra && campos.precioVenta){

        document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo')
        document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo')

        setTimeout(() => {
			document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
        }, 8000);

        document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
    }
    else {
        e.preventDefault()
        document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo')
    }

})
    
