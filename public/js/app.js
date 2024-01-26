
setTimeout(aplicarFadeOut, 3000);

function aplicarFadeOut() {

    console.log('aplicando fadeout')
    var elemento = document.querySelector('.popup');

    // Verificar si el elemento existe y tiene la clase 'fadeout'
    if (elemento) {
        // Aplicar la clase 'hidden' para iniciar el fade-out
        elemento.classList.add('hidden');
    }
}

function validatePass(form){


    var password = document.forms[form]["password"].value;

    if (password == '' || password == null) {
        mostrarError("Introduce una contraseña");
        return false;
      }

      if (password.length <= 4) {
        mostrarError("La contraseña debe tener más de 4 caracteres");
        return false;
      }

      if (!/[A-Z]/.test(password)) {
        mostrarError("La contraseña debe contener al menos una letra mayúscula");
        return false;
      }

      // Si la validación pasa, puedes continuar con el envío del formulario
      return true;
   

}


function mostrarError(mensaje) {
    Swal.fire({
      title: 'Error',
      text: mensaje,
      icon: 'error',
      confirmButtonText: 'Volver'
    });
  }