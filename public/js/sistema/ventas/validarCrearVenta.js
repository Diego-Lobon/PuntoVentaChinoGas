const formulario = document.getElementById('formulario')
const inputs = document.querySelectorAll("#formulario input");
const selects = document.querySelectorAll("#formulario select");

const expresiones = {
    nombreCliente: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/, // Letras y espacios, pueden llevar acentos.
    direccion: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/,
    celular: /^\d{9,9}$/, // 7 a 14 numeros.
    cantidad: /^\d{1,10000}$/, 

}

const campos = {
    nombreCliente: false,
    select_vendedor: false,
    direccion: false,
    celular: false,
    cantidad: false,
    select_producto: false,
    select_tipo_cliente: false,
    select_tipo_pago: false
}

/* VALIDACION PARA NO CREAR UN PRODUCTO REPETIDO CON MISMO NOMBRE */ 



/************************************************************/

const validarFormulario = (e) => {
        switch (e.target.name) {
            case "nombreCliente":
                validarCampo(expresiones.nombreCliente, e.target, 'nombreCliente')   
            break;
            case "direccion":
                validarCampo(expresiones.direccion, e.target, 'direccion')
            break;
            case "celular":
                validarCampo(expresiones.celular, e.target, 'celular')
            break;
            case "cantidad":
                validarCampo(expresiones.cantidad, e.target, 'cantidad')
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
      case "select_vendedor":
          validarSelect(e.target, "select_vendedor")   
      break;
      case "select_producto":
          validarSelect(e.target, "select_producto")   
      break;
      case "select_tipo_cliente":
          validarSelect(e.target, "select_tipo_cliente")   
      break;
      case "select_tipo_pago":
          validarSelect(e.target, "select_tipo_pago")   
      break;
  }    
}

const validarSelect = (input, campo) => {
  console.log(input.value)
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

  select.addEventListener('blur', ()=>{
    if(select.value == "default" ){
      select.classList.remove('inputFocusActived');
    }

  })



  select.addEventListener('change', validarFormularioSelect)

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

function validarDisable(elemento, campo){

  if(elemento.disabled){
    elemento.disabled = false;
    campos[campo] = true
  }

}


formulario.addEventListener('submit', (e) => {

  console.log(campos.nombreCliente)
  console.log(campos.direccion)
  console.log(campos.celular)
  console.log(campos.cantidad)
  console.log(campos.select_vendedor)
  console.log(campos.select_producto)
  console.log(campos.select_tipo_cliente)
  console.log(campos.select_tipo_pago)

  inputs.forEach((input) => {
    validarDisable(input, input.name)
  })

  selects.forEach((select) => {
    validarDisable(select, select.name)
  })

  if(campos.nombreCliente && campos.direccion && campos.celular && campos.cantidad && campos.select_vendedor && campos.select_producto && campos.select_tipo_cliente && campos.select_tipo_pago){

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
    
