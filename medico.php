<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>S.I.G.A.M. - Médico</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="medicos">

            <h1>Atención Médica</h1>

            <div>

                <p>Paciente en Turno:</p>

                <h2 id="turnoActual">SIN TURNO</h2>

                <p><strong>Nombre:</strong> <span id="nombreActual">---</span></p>

            </div>

            <div class="botones">
                <input type="submit" value="Llamar Siguiente"
                onclick="llamarTurno()">
                <input type="submit" value="Finalizar Consulta"
                onclick="finalizarTurno()">
            </div>

            <br><br>
            <a href="index.php">Cerrar Sesión</a>

        </div>

<script>
let turnoActual = null;

// Cargar automático al iniciar la página
window.onload = function() {

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    if (turnos.length === 0) {
        document.getElementById("turnoActual").innerText = "SIN TURNO";
        document.getElementById("nombreActual").innerText = "---";
        return;
    }

    // Obtiene el primer turno de la lista
    turnoActual = turnos.shift();
    localStorage.setItem("turnos", JSON.stringify(turnos));

    let partes = turnoActual.split(" - ");

    document.getElementById("turnoActual").innerText = partes[0];
    document.getElementById("nombreActual").innerText = partes[1];
};


// LLAMAR TURNO
function llamarTurno() {

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    if (turnos.length === 0) {
        alert("NO HAY TURNOS");
        return;
    }

    turnoActual = turnos.shift();
    localStorage.setItem("turnos", JSON.stringify(turnos));

    let partes = turnoActual.split(" - ");

    document.getElementById("turnoActual").innerText = partes[0];
    document.getElementById("nombreActual").innerText = partes[1];
}


// FINALIZAR TURNO
function finalizarTurno() {

    if (turnoActual == null) {
        alert("SIN TURNOS EN ESPERA");
        return;
    }

    alert("TURNO Finalizado");

    // GUARDA EN HISTORIAL
    let historial = JSON.parse(localStorage.getItem("historial")) || [];

    // CAMBIA ESTADO A ATENDIDO
    let turnoFinal = turnoActual + " - ATENDIDO";
    historial.push(turnoFinal);

    localStorage.setItem("historial", JSON.stringify(historial));

    // LIMPIA PANTALLA
    document.getElementById("turnoActual").innerText = "SIN TURNO";
    document.getElementById("nombreActual").innerText = "---";

    turnoActual = null;
}
</script>

    </body>
</html>