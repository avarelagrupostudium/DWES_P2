<?php
include('conexion.php');
include('reyesMagosConsultas.php');


try {
    $conexionC = new Conexion;
    $conexion = $conexionC->connectarBD();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $consultaReyMago = new ReyesMagosConsultas($conexion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$melchor = 'Melchor';
$gaspar = 'Gaspar';
$baltasar = 'Baltasar';
try {
    $listadoMelchor= $consultaReyMago->listadoRegalosReyMago($melchor);
    $listadoGaspar= $consultaReyMago->listadoRegalosReyMago($gaspar);
    $listadoBaltasar= $consultaReyMago->listadoRegalosReyMago($baltasar);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>



<!doctype html>
<html lang="en">
    <head>
        <title>Búsqueda</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.3.2 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
        <nav class="navbar bg-body-tertiary navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="assets/icono-ciclos-2022.png" alt="GrupoStudium" width="50" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="ninos.php">Niños</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="regalos.php">Regalos</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="busqueda.php">Búsqueda</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="reyesMagos.php">Reyes Magos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        </header>
        <div class="container-fluid col-10">
            <div class="row">
            <?php
                tablaRegalosReyMago($listadoMelchor,$melchor);
                tablaRegalosReyMago($listadoGaspar,$gaspar);
                tablaRegalosReyMago($listadoBaltasar,$baltasar);
            ?> 
            </div>
            
        </div>
        <footer>
            <!-- place footer here -->
        </footer>
        <?php
    function tablaRegalosReyMago($listado,$reyMago)
    {
        $dinero = 0;
        echo ' 
                    <table class="table table-striped my-5">
                        <tr>
                        <th colspan="3" class=text-center>'.$reyMago.'</th>
                        </tr>
                        <tr>
                            <th class= "col-6">Nombre del juguete</th>
                            <th class= "col-2">Nombre</th>
                            <th class= "col-4">Apellidos</th>
                        </tr>';
        while ($fila = $listado->fetch_assoc()) {
            $nombreRegalo = $fila['nombreRegalo'];
            if($fila['bueno']+0 == 0){
                $nombreRegalo = 'Carbón';
                $dinero = $dinero + 0;
            }else{
                $dinero = $dinero + $fila['precio'];
            }
            echo    '<tr>
                            <td>' . $nombreRegalo . '</td>
                            <td>' . $fila['nombreNino'] . '</td>
                            <td>' . $fila['apellidosNino'] . '</td>
                            
                                
                    </tr>';
        }
        
        echo '
                <tr>
                <td></td>
                <td></td>
                <td>Total gastado: '.$dinero.' €</td>
                </tr>
            </table>
        ';
    }
    ?>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
