<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PANTALLA DE TURNOS</title>
</head>

<body>

<div class="pacientew">

    <h1>PANTALLA DE TURNOS</h1>

    <!-- 🔥 TURNO SIGUIENTE -->
    <h2>TURNO SIGUIENTE</h2>
    <h1 id="siguiente" style="color: green;">---</h1>

    <!-- 🔥 LISTA DE ESPERA -->
    <h2>TURNOS EN ESPERA</h2>
    <ul id="lista"></ul>

</div>

<script>

// 🔥 CARGAR TURNOS DESDE LOCALSTORAGE
function cargarTurnos(){

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    let lista = document.getElementById("lista");
    let siguiente = document.getElementById("siguiente");

    lista.innerHTML = "";

    if(turnos.length > 0){

        // PRIMER TURNO
        let partes = turnos[0].split(" - ");
        siguiente.innerText = partes[0];

        // RESTO DE TURNOS
        for(let i = 1; i < turnos.length; i++){

            let partes = turnos[i].split(" - ");
            let li = document.createElement("li");

            li.innerText = partes[0] + " - " + partes[1];

            lista.appendChild(li);
        }

    } else {
        siguiente.innerText = "SIN TURNOS";
    }
}

// 🔁 ACTUALIZA CADA 2 SEGUNDOS
setInterval(cargarTurnos, 2000);

</script>

</body>
</html>