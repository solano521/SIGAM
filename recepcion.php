<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>S.I.G.A.M. - Recepción</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="recepcion">

            <header>
                <h2>GENERAR TURNOS</h2>
            </header>

            <div class="tarjeta">
                <h3>Registrar Paciente</h3>

                <form class="datos"> <div id="alertaIncompletos" style="display: none; align-items: center; justify-content: center; background-color: #ffe6e6; border: 1px solid #ff4d4d; border-radius: 12px; padding: 10px; margin-bottom: 15px;">
                        <span style="color: #ff4d4d; font-size: 18px; margin-right: 8px;">⚠️</span>
                        <strong style="color: #ff4d4d; font-family: 'Courier New', Courier, monospace; font-size: 14px;">DATOS INCOMPLETOS</strong>
                    </div>

                    <input type="text" id="nombre" placeholder="Nombre Completo" required>
                    <input type="number" id="edad" placeholder="Edad" required>
                    <input type="date" id="fecha" required>
                    <input type="text" id="curp" placeholder="CURP" required>

                    <select id="sexo">
                        <option value="">Seleccione Género</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Therian">OTRO</option>
                    </select>

                    <select id="especialidad">
                        <option value="">Seleccione Especialidad</option>
                        <option>Médico General</option>
                        <option>Pediatría</option>
                        <option>Nutrición</option>
                    </select>

                    <button type="button" onclick="generarTurno()" class="btn">Generar Turno</button>
                    <div id="mensajeTurno"></div>

                </form>
            </div>

            <h3 style="text-align:center">Lista de Espera</h3> 
            <ul id="listaTurnos"></ul>

            <div style="text-align: center; margin-top: 20px;">
                <a href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
            </div>
        </div>


<script>
let contador = 1;

function cerrarSesion(){
    // borrar datos
    localStorage.clear();

    // reiniciar contador
    contador = 1;

    // redirigir al login versión PHP
    window.location.href = "index.php";
}

/* ===== CARGAR LISTA AL INICIAR ===== */
window.onload = function(){
    cargarLista();
};

/* ===== GENERAR TURNO ===== */
function generarTurno(){
    let nombre = document.getElementById("nombre").value;
    let edad = document.getElementById("edad").value;
    let sexo = document.getElementById("sexo").value;
    let curp = document.getElementById("curp").value;
    let esp = document.getElementById("especialidad").value;
    let fech = document.getElementById("fecha").value;

    let alerta = document.getElementById("alertaIncompletos");
    let msg = document.getElementById("mensajeTurno");

    if(nombre=="" || edad=="" || sexo=="" || curp=="" || esp=="" || fech==""){
        alerta.style.display="flex";
        msg.innerHTML="";

        setTimeout(function(){
            alerta.style.display="none";
        },4000);

        return;
    }

    alerta.style.display="none";

    let turno = "P-" + String(contador).padStart(2,'0');

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    turnos.push(turno + " - " + nombre + " - " + esp);

    localStorage.setItem("turnos", JSON.stringify(turnos));

    msg.innerHTML =
    "<h3 style='color:green;text-align:center'>SU TURNO ES: "+turno+"</h3>";

    // IMPRIMIR 🧾
    let ventana = window.open("", "", "width=400,height=300");

    ventana.document.write(`
        <h2 style="text-align:center;">TURNO</h2>
        <h1 style="text-align:center;">${turno}</h1>
        <p style="text-align:center;">${nombre}</p>
        <p style="text-align:center;">${esp}</p>
    `);

    ventana.print();

    contador++;
    cargarLista();
}

/* ===== CARGAR LISTA ===== */
function cargarLista(){
    let listaHTML = document.getElementById("listaTurnos");
    listaHTML.innerHTML = "";

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    turnos.forEach(t => {
        let partes = t.split(" - ");
        let turno = partes[0];
        let nombre = partes[1];
        let esp = partes[2];

        let item = document.createElement("li");

        item.innerHTML =
            "<span class='textoTurno'><strong>"+turno+
            "</strong> - "+nombre+" - "+esp+"</span> "+
            "<button onclick='modificarTurno(this)'>Modificar</button> "+
            "<button onclick='eliminarTurno(this)'>Eliminar</button>";

        listaHTML.appendChild(item);
    });

    // actualizar contador automáticamente para evitar duplicados al recargar
    if(turnos.length > 0){
        let ultimo = turnos[turnos.length - 1].split(" - ")[0];
        let num = parseInt(ultimo.split("-")[1]);
        contador = num + 1;
    }
}

/* ===== ELIMINAR ===== */
function eliminarTurno(boton){
    let li = boton.parentElement;
    let turno = li.querySelector("strong").innerText;

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    turnos = turnos.filter(t => !t.includes(turno));

    localStorage.setItem("turnos", JSON.stringify(turnos));

    cargarLista();
}

/* ===== MODIFICAR (SOLO NOMBRE) ===== */
function modificarTurno(boton){
    let li = boton.parentElement;
    let nuevoNombre = prompt("Nuevo nombre:");

    if(nuevoNombre){
        let turno = li.querySelector("strong").innerText;
        let texto = li.querySelector(".textoTurno").innerText;
        let partes = texto.split(" - ");
        let esp = partes[2]; 

        let turnos = JSON.parse(localStorage.getItem("turnos")) || [];
        let index = turnos.findIndex(t => t.includes(turno));

        if(index !== -1){
            turnos[index] = turno + " - " + nuevoNombre + " - " + esp;
        }

        localStorage.setItem("turnos", JSON.stringify(turnos));
        cargarLista();
    }
}
</script>

    </body>
</html>