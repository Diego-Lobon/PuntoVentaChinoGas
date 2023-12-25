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
    password_new: false,
    rol: false
}

/* VALIDACION PARA NO CREAR UN PRODUCTO REPETIDO CON MISMO NOMBRE */ 

function enviarValor(inputValue, input, campo, peticion) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const idUsuario = document.getElementById('idElemento');
    const password = document.getElementById('password');
    fetch('http://127.0.0.1:8000/usuarios/'+idUsuario.value+'/editar', {
        method: 'POST',
        body: JSON.stringify({inputValue: inputValue, idUsuario: idUsuario.value, password: password.value}),
        headers: {
            'Content-Type': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

            if(data.data != 1 && peticion == 'trueUsername' ||data.resultadoPassword == true && peticion == 'truePassword'){
                document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto')
                document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto')
                document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle')
                document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle')
                document.querySelector(`#grupo__${campo} .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                campos[campo] = true
            }
            else {
                
                document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto')
                document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto')
                document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle')
                document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle')
                document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo')
                document.querySelector(`#grupo__${campo} .formulario__input-error2`).classList.add('formulario__input-error-activo')
                campos[campo] = false
            }
            const mensaje = document.querySelector(`#grupo__${campo} #formulario__input-error2`)
            if(!mensaje.classList.contains('formulario__input-error-activo')){
                console.log("entro")
                document.querySelector(`#grupo__${campo} .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                if (campo == 'username') {
                    validarCampo(expresiones.username, input, campo)
                }
                else if(campo == 'password'){
                    validarCampo(expresiones.password, input, campo)
                }
                
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
                    validarCampo(expresiones.username, e.target, 'username', 'trueUsername')
                } else {
                    document.querySelector(`#grupo__username .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    enviarValor(e.target.value, e.target, "username", 'trueUsername');
                } 
                
            break;
            case "nombreUsuario":
                validarCampo(expresiones.nombreUsuario, e.target, 'nombreUsuario')   
            break;
            case "password":
                //validarCampo(expresiones.password, e.target, 'password')
                if (e.target.value.trim() == "") {
                    document.querySelector(`#grupo__password .formulario__input-error2`).classList.remove('formulario__input-error-activo')
                    validarCampo(expresiones.password, e.target, 'password', 'truePassword')
                } else {
                    document.querySelector(`#grupo__password .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    enviarValor(e.target.value, e.target, "password", 'truePassword');
                } 
            break;
            case "password_new":
			    validarCampo(expresiones.password, e.target, 'password_new')
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

const inputUsername = document.querySelector('#username')
const inputNombreUsuario = document.querySelector('#nombreUsuario')
const inputPassword = document.querySelector('#password')
const inputRol = document.querySelector('#rol')

validarCampo(expresiones.username, inputUsername, 'username')
inputUsername.classList.add("inputFocusActived");

validarCampo(expresiones.nombreUsuario, inputNombreUsuario, 'nombreUsuario')
inputNombreUsuario.classList.add("inputFocusActived");


validarCampo(expresiones.rol, inputRol, 'rol')
inputRol.classList.add("inputFocusActived");


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

    if(campos.username && campos.nombreUsuario && campos.password && campos.password_new && campos.rol){

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
    
