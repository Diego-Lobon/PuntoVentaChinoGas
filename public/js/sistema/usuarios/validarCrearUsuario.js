const formulario = document.getElementById('formulario')
const inputs = document.querySelectorAll("#formulario input");

const expresiones = {
    username: /^[^-\s][a-zA-Z0-9\_\-]{3,16}$/, // Letras, numeros, guion y guion_bajo
    nombreUsuario: /^[^-\s][a-zA-ZÀ-ÿ0-9\s]{0,99}$/, // Letras y espacios, pueden llevar acentos.
    password: /^[^-\s].{3,12}$/, // 4 a 12 digitos.
    rol: /^[^-\s][a-zA-ZÀ-ÿ\s]{1,40}$/,
}

const campos = {
    username: false,
    nombreUsuario: false,
    password: false,
    rol: false
}

/* VALIDACION PARA NO CREAR UN PRODUCTO REPETIDO CON MISMO NOMBRE */ 

function enviarValor(inputValue, input) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('https://puntoventachinogas-production.up.railway.app/usuarios/crear', {
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
            document.getElementById(`grupo__username`).classList.remove('formulario__grupo-incorrecto')
            document.getElementById(`grupo__username`).classList.add('formulario__grupo-correcto')
            document.querySelector(`#grupo__username i`).classList.add('fa-check-circle')
            document.querySelector(`#grupo__username i`).classList.remove('fa-times-circle')
            document.querySelector(`#grupo__username .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            campos[username] = true
        }
        else {
            document.getElementById(`grupo__username`).classList.add('formulario__grupo-incorrecto')
            document.getElementById(`grupo__username`).classList.remove('formulario__grupo-correcto')
            document.querySelector(`#grupo__username i`).classList.add('fa-times-circle')
            document.querySelector(`#grupo__username i`).classList.remove('fa-check-circle')
            document.querySelector(`#grupo__username .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__username .formulario__input-error2`).classList.add('formulario__input-error-activo')
            campos[username] = false
        }
        const mensaje = document.querySelector('#formulario__input-error2')
        if(!mensaje.classList.contains('formulario__input-error-activo')){
            console.log("entro")
            document.querySelector(`#grupo__username .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            validarCampo(expresiones.username, input, 'username')
        }
        
      // Aquí se maneja la respuesta de Laravel
    })
    .catch(error => console.error(error));
  }

/************************************************************/

const validarFormulario = (e) => {
    
        switch (e.target.name) {
            case "username":
                if (e.target.value.trim() == "") {
                    document.querySelector(`#grupo__username .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                    validarCampo(expresiones.username, e.target, 'username')
                } else {
                    document.querySelector(`#grupo__username .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    enviarValor(e.target.value, e.target);
                } 
                
            break;
            case "nombreUsuario":
                validarCampo(expresiones.nombreUsuario, e.target, 'nombreUsuario')   
            break;
            case "password":
                validarCampo(expresiones.password, e.target, 'password')
                validarPasswordConfirmation();
            break;
            case "password_confirmation":
			    validarPasswordConfirmation();
		    break;
            case "rol":
                validarCampo(expresiones.rol, e.target, 'rol')
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

const validarPasswordConfirmation = () => {
    
	const inputPassword1 = document.getElementById('password');
	const inputPassword2 = document.getElementById('password_confirmation');

    const valid = document.getElementById('validar_password')

	if(inputPassword1.value !== inputPassword2.value || inputPassword1.value == ""){
        document.getElementById(`grupo__password_confirmation`).classList.add('formulario__grupo-incorrecto')
        document.getElementById(`grupo__password_confirmation`).classList.remove('formulario__grupo-correcto')
        document.querySelector(`#grupo__password_confirmation i`).classList.add('fa-times-circle')
        document.querySelector(`#grupo__password_confirmation i`).classList.remove('fa-check-circle')
        
        if (inputPassword1.value == "") {
            
            document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.add('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')
        }
        else {
            document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.add('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')

        } 

        if (valid.classList.contains('formulario__input-error-activo')){
            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.add('formulario__input-error-activo')
        }
        else{
            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')
        }
    
        campos['password'] = false
    }
    else {
        
        /*
        const gg = valid.classList.contains('formulario__input-error-activo')
        console.log(gg)
        console.log(valid)
        */
        
        if (valid.classList.contains('formulario__input-error-activo')) {
            document.getElementById(`grupo__password_confirmation`).classList.add('formulario__grupo-incorrecto')
            document.getElementById(`grupo__password_confirmation`).classList.remove('formulario__grupo-correcto')
            document.querySelector(`#grupo__password_confirmation i`).classList.add('fa-times-circle')
            document.querySelector(`#grupo__password_confirmation i`).classList.remove('fa-check-circle')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.add('formulario__input-error-activo')
        } else {

            document.getElementById(`grupo__password_confirmation`).classList.remove('formulario__grupo-incorrecto')
            document.getElementById(`grupo__password_confirmation`).classList.add('formulario__grupo-correcto')
            document.querySelector(`#grupo__password_confirmation i`).classList.remove('fa-times-circle')
            document.querySelector(`#grupo__password_confirmation i`).classList.add('fa-check-circle')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.remove('formulario__input-error-activo')
            document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.remove('formulario__input-error-activo')

            document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')
        }
        
        campos['password'] = true
    }
}

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
        
      } else {
        if (input.name == 'password_confirmation') {
            const inputPass = document.getElementById('password');
                if (inputPass.value == "") {
                    document.getElementById(`grupo__password_confirmation`).classList.add('formulario__grupo-incorrecto')
                    document.getElementById(`grupo__password_confirmation`).classList.remove('formulario__grupo-correcto')
                    document.querySelector(`#grupo__password_confirmation i`).classList.add('fa-times-circle')
                    document.querySelector(`#grupo__password_confirmation i`).classList.remove('fa-check-circle')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.add('formulario__input-error-activo')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')
                }  
                else {
                    mostrarMensaje(expresiones['password'], input, input.name);
                }  
        } else {
            
            mostrarMensaje(expresiones[input.name], input, input.name);
        }
      }
    });
    
    input.addEventListener("keydown", function(event) {
        
      if (event.key === "Backspace" || event.key === "Delete") {
        borrarPresionado = true;
        if (input.value === "") {
            
            if (input.name == 'password_confirmation') {  
                const inputPass = document.getElementById('password');
                if (inputPass.value == "") {
                    document.getElementById(`grupo__password_confirmation`).classList.add('formulario__grupo-incorrecto')
                    document.getElementById(`grupo__password_confirmation`).classList.remove('formulario__grupo-correcto')
                    document.querySelector(`#grupo__password_confirmation i`).classList.add('fa-times-circle')
                    document.querySelector(`#grupo__password_confirmation i`).classList.remove('fa-check-circle')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.add('formulario__input-error-activo')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    document.querySelector(`#grupo__password_confirmation .formulario__input-error3`).classList.remove('formulario__input-error-activo')
                }  
                else {
                    mostrarMensaje(expresiones['password'], input, input.name);
                }            
                
            } else {
                mostrarMensaje(expresiones[input.name], input, input.name);
            }
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
        if (input.name == 'password_confirmation') {
            console.log(input.name)
            if(input.value == ""){
                document.querySelector(`#grupo__password_confirmation .formulario__input-error2`).classList.add('formulario__input-error-activo');
            }
            mostrarMensaje(expresiones['password'], input, input.name);
        } else {
            mostrarMensaje(expresiones[input.name], input, input.name);
        }
        
      }
    });
    
})


formulario.addEventListener('submit', (e) => {
    
    const tipoCliente = document.getElementById("tipo");

    if(campos.username && campos.nombreUsuario && campos.password && campos.rol){

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
    
