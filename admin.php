<!DOCTYPE html>
<html lang="es">
<head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>S.I.G.A.M. - Admin</title>

        <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="Admin">

        <h2>PANEL ADMINISTRADOR</h2>

        <h3>Ver historial de turnos</h3>
        <button onclick="verHistorial()">Historial</button>

        <br><br>

        <h3>Consultar turno</h3>
        <input type="text" id="dato" placeholder="Nombre o Turno">
        <button onclick="consultarTurno()">Consultar</button>

        <br><br>

        <button onclick="generarReporte()">Generar Reporte</button>

        <p id="resultado">SIN INFORMACIÓN</p>

        <a href="index.php">Cerrar Sesión</a>

</div>


<script>
// VE HISTORIAL REAL
function verHistorial(){

    let historial = JSON.parse(localStorage.getItem("historial")) || [];

    if(historial.length == 0){
        document.getElementById("resultado").innerHTML = "NO HAY REGISTROS";
        return;
    }

    let texto = "HISTORIAL <br><br>";

    historial.forEach(t => {
        texto += t + "<br>";
    });

    document.getElementById("resultado").innerHTML = texto;
}


// CONSULTA HISTORIAL
function consultarTurno(){
        
    let dato = document.getElementById("dato").value;

    let historial = JSON.parse(localStorage.getItem("historial")) || [];

    let texto = "RESULTADO <br><br>";
    let encontrado = false;

    historial.forEach(t => {
        if(t.includes(dato)){
            texto += t + "<br>";
            encontrado = true;
        }
    });

    if(!encontrado){
        texto = "NO SE ENCONTRÓ";
    }

    document.getElementById("resultado").innerHTML = texto;
}


// REPORTE 
function generarReporte(){

    // Se mantiene la referencia a "HISTORIAL" (en mayúsculas) tal cual estaba en el original
    let historial = JSON.parse(localStorage.getItem("HISTORIAL")) || [];

    let total = historial.length;
    let atendidos = 0;

    // Conteo inicial basado en la cadena específica
    historial.forEach(t => {
        if(t.includes("PACIENTES ATENDIDOS")){
            atendidos++;
        }
    });
 
    let espeCi = JSON.parse(localStorage.getItem("ESPECIALIDADES")) || [];

    // Variables de especialidad
    let pediatria = 0;
    let general = 0;
    let nutricion = 0;

    historial.forEach(t => {

        if(t.includes("ATENDIDO")){
            atendidos++;
        }

        if(t.includes("Pediatría")){
            pediatria++;
        }

        if(t.includes("Médico General")){
            general++;
        }

        if(t.includes("Nutrición")){
            nutricion++;
        }

    });


    document.getElementById("resultado").innerHTML =
    "REPORTE <br>" +
    "TOTAL: " + total + "<br>" +
    "ATENDIDOS: " + atendidos + "<br><br><br>" +

    "ESPECIALIDAD<br>"+
    "PEDIATRÍA: " + pediatria + " pacientes<br>" +
    "MÉDICO GENERAL: " + general + " pacientes<br>" +
    "NUTRICIÓN: " + nutricion + " pacientes";
}


function verificarAlertas(){

    let turnos = JSON.parse(localStorage.getItem("turnos")) || [];

    if(turnos.length > 5){
        alert("HAY PACIENTES EN ESPERA");
    }
}

window.onload = function(){
    verificarAlertas();
}
</script>

</body>
</html>