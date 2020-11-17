
function cambiar() {
    var body = document.getElementById("bodi");
    var array = ['blue', 'red', 'yellow', 'purple', 'green', 'wheat', 'white'];
    var i = 0;
    intervalo = setInterval(function () {
        body.style.backgroundColor = array[i % 7];
        i++;
    });
}

function parar() {
    clearInterval(intervalo);
}

function cargar() {
    var cambio = document.getElementById("cambioColor");
    cambio.addEventListener('click', cambiar, false);

    var quitar = document.getElementById("quitar");
    quitar.addEventListener('click', parar, false);
}

window.addEventListener('load', cargar, false);