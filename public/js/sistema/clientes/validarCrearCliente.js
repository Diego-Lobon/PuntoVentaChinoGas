const formulario = document.getElementById('formulario')
const inputs = document.querySelectorAll("#formulario input");
const selects = document.querySelectorAll("#formulario select");

const expresiones = {
    nombreCliente: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/, // Letras y espacios, pueden llevar acentos.
    direccion: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/,
    celular: /^\d{9,9}$/, // 7 a 14 numeros.
}

const campos = {
    nombreCliente: false,
    direccion: false,
    celular: false,
    tipo: false
}

/* VALIDACION PARA NO CREAR UN PRODUCTO REPETIDO CON MISMO NOMBRE */ 

function enviarValor(inputValue, input) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('http://127.0.0.1:8000/clientes/crear', {
        method: 'POST',
        body: JSON.stringify({inputValue: inputValue}),
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
            document.getElementById(`grupo__nombreCliente`).classList.remove('formulario__grupo-incorrecto')
            document.getElementById(`grupo__nombreCliente`).classList.add('formulario__grupo-correcto')
            document.querySelector(`#grupo__nombreCliente i`).classList.add('fa-check-circle')
            document.querySelector(`#grupo__nombreCliente i`).classList.remove('fa-times-circle')
            document.querySelector(`#grupo__nombreCliente .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            campos[nombreCliente] = true
        }
        else {
            document.getElementById(`grupo__nombreCliente`).classList.add('formulario__grupo-incorrecto')
            document.getElementById(`grupo__nombreCliente`).classList.remove('formulario__grupo-correcto')
            document.querySelector(`#grupo__nombreCliente i`).classList.add('fa-times-circle')
            document.querySelector(`#grupo__nombreCliente i`).classList.remove('fa-check-circle')
            document.querySelector(`#grupo__nombreCliente .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__nombreCliente .formulario__input-error2`).classList.add('formulario__input-error-activo')
            campos[nombreCliente] = false
        }
        const mensaje = document.querySelector('#formulario__input-error2')
        if(!mensaje.classList.contains('formulario__input-error-activo')){
            console.log("entro")
            document.querySelector(`#grupo__nombreCliente .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            validarCampo(expresiones.nombreCliente, input, 'nombreCliente')
        }
        
      // Aquí se maneja la respuesta de Laravel
    })
    .catch(error => console.error(error));
  }

/************************************************************/

const validarFormulario = (e) => {
        switch (e.target.name) {
            case "nombreCliente":
                if (e.target.value.trim() == "") {
                    document.querySelector(`#grupo__nombreCliente .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                    validarCampo(expresiones.nombreCliente, e.target, 'nombreCliente')
                } else {
                    document.querySelector(`#grupo__nombreCliente .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    enviarValor(e.target.value, e.target);
                }    
            break;
            case "direccion":
                validarCampo(expresiones.direccion, e.target, 'direccion')
            break;
            case "celular":
                validarCampo(expresiones.celular, e.target, 'celular')
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

function mostrarMensaje(expresion, input, campo) {
  if (document.querySelector(`#grupo__${campo} .formulario__input-error2`)) {
    document.querySelector(`#grupo__${campo} .formulario__input-error2`).classList.remove('formulario__input-error-activo')
  }
  validarCampo(expresion, input, campo)
}


const validarFormularioSelect = (e) => {
  switch (e.target.name) {
      case "tipo":
          validarSelect(e.target, "tipo")   
      break;
  }    
}

const validarSelect = (input, campo) => {
    
  if(input.value != 'default'){
      document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto')
      document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto')
      document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo')
      campos[campo] = true
  }
  else {
      document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto')
      document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto')  
      document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo')
      campos[campo] = false
  }

}


selects.forEach((select) => {

  select.addEventListener('focus', ()=>{
    if(!select.classList.contains('inputFocusActived')){
      select.classList.add("inputFocusActived");
    }
  })

  select.addEventListener('change', validarFormularioSelect)
  select.addEventListener('blur', validarFormularioSelect)

})

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

    let borrarPresionado = false;

    input.addEventListener("input", function() {
      if (input.value !== "") {
        console.log('nada')
      } else {
        mostrarMensaje(expresiones[input.name], input, input.name);
      }
    });
    
    input.addEventListener("keydown", function(event) {
      if (event.key === "Backspace" || event.key === "Delete") {
        borrarPresionado = true;
        if (input.value === "") {
          mostrarMensaje(expresiones[input.name], input, input.name);
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
        mostrarMensaje(expresiones[input.name], input, input.name);
      }
    });
    
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

formulario.addEventListener('submit', (e) => {
    
    const tipoCliente = document.getElementById("tipo");

    if(campos.nombreCliente && campos.direccion && campos.celular && tipoCliente.value != 'Seleccion un Tipo'){

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
    
