
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

