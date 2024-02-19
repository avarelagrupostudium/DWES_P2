<?php
include('conexion.php');
include('ninosConsultas.php');
try {
    $conexionC = new Conexion;
    $conexion = $conexionC->connectarBD();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $consultaNinos = new NinosConsultas($conexion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
if (isset($_POST['nombreNino'])) {
    $nombre = $_POST['nombreNino'];
    $apellidos = $_POST['apellidosNino'];
    $fechaNacimiento = $_POST['fechaNacimientoNino'];
    $bueno = $_POST['buenoNino'];
    try {
        $consultaNinos->insertarNino($nombre, $apellidos, $fechaNacimiento, $bueno);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['eliminarNino'])) {
    try {
        $listadoNinos = $consultaNinos->eliminarNino($_POST['eliminarNino']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['modificarNino'])) {
    try {
        $ninoSeleccionado = $consultaNinos->datosNino($_POST['modificarNino']);
        if ($ninoSeleccionado->num_rows > 0) {
            $fila = $ninoSeleccionado->fetch_assoc();
            $idModNino = $fila['idNino'];
            $nombreModNino = $fila['nombre'];
            $apellidosModNino = $fila['apellidos'];
            $fechaModNino = $fila["fechaNacimiento"];
            $buenoModNino = $fila["bueno"];
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['nombreNinoMod'])) {
    $consultaNinos->modificarNino($_POST['idNinoMod'], $_POST['nombreNinoMod'], $_POST['apellidosNinoMod'], $_POST['fechaNacimientoNinoMod'], $_POST['buenoNinoMod'] + 0);
}
try {
    $listadoNinos = $consultaNinos->listadoNinos();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
mysqli_close($conexion);    //cerrar conexión con el servidor
?>



<!doctype html>
<html lang="en">

<head>
    <title>Niños</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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
                            <a class="nav-link" href="reyesMagos.php">Reyes Magos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid col-10">
        <div class="row">
            <?php
            if ($listadoNinos->num_rows > 0) {
                tablaNinos($listadoNinos);
            }
            ?>
        </div>

        <div class="row" <?php if (isset($_POST['modificarNino'])) {
                                echo "style='display: none'";
                            } ?>>
            <h2 class="text-center">Añadir un niño a la lista</h2>
            <form class="col-8 mx-auto" action="ninos.php" method="post" id="addNino">
                <div class="mb-3">
                    <label for="nombreNino" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombreNino" name="nombreNino" required>
                </div>
                <div class="mb-3">
                    <label for="apellidosNino" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidosNino" name="apellidosNino" required>
                </div>
                <div class="mb-3">
                    <label for="fechaNacimientoNino" class="form-label">Fecha de nacimiento:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="fechaNacimientoNino" name="fechaNacimientoNino" required>
                </div>
                <div class="mb-3">
                    <label for="buenoNino" class="form-label">El niño ha sido bueno ?:</label>
                    <select id="buenoNino" name="buenoNino" class="form-select" required>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </form>
            <form action="ninos.php" id="cancelarAddNino"></form>
            <div class="col-8 mx-auto">
                <button type="submit" class="btn btn-success col-5 m-2" form="addNino">Añadir niño</button>
                <button type="submit" class="btn btn-danger col-5 m-2" form="cancelarAddNino">Cancelar</button>
            </div>
        </div>

        <div class="row" <?php if (isset($_POST['modificarNino'])) {
                                echo "style=''";
                            } else {
                                echo "style='display:none'";
                            } ?>>
            <h2 class="text-center">Modificar los datos de <?php echo $nombreModNino ?></h2>
            <form class="col-8 mx-auto" action="ninos.php" method="post" id="modificarNino">
                <div class="mb-3">
                    <label for="nombreNino" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombreNino" name="nombreNinoMod" value="<?php echo $nombreModNino ?>" required>
                </div>
                <div class="mb-3">
                    <label for="apellidosNino" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidosNino" name="apellidosNinoMod" value="<?php echo $apellidosModNino ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fechaNacimientoNino" class="form-label">Fecha de nacimiento:</label>
                    <input type="date" class="form-control" value="<?php echo $fechaModNino; ?>" id="fechaNacimientoNino" name="fechaNacimientoNinoMod" required>
                </div>
                <div class="mb-3">
                    <label for="buenoNino" class="form-label">El niño ha sido bueno ?:</label>
                    <select id="buenoNino" name="buenoNinoMod" class="form-select" required>
                        <option value="1">Si</option>
                        <option value="0" <?php if ($buenoModNino == 0) {
                                                echo 'selected';
                                            } ?>>No</option>
                    </select>
                </div>
                <input type="hidden" name="idNinoMod" value="<?php echo $idModNino; ?>">
            </form>
            <form action="ninos.php" method="post" id="cancelarModNino"></form>
            <div class="col-8 mx-auto">
                <button type="submit" class="btn btn-success col-5 m-2" form="modificarNino">Modificar datos</button>
                <button type="submit" class="btn btn-danger col-5 m-2" form="cancelarModNino">Cancelar</button>
            </div>
        </div>
    </div>





    <footer>
        <!-- place footer here -->
    </footer>
    <?php
    function tablaNinos($listado)
    {
        echo ' 
                <table class="table table-striped my-5">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th class="text-center">Fecha de nacimiento</th>
                        <th class="text-center">Bueno (sí/no)</th>
                        <th class="text-center">Eliminar</th>
                        <th class="text-center">Modificar</th>
                    </tr>';
        while ($fila = $listado->fetch_assoc()) {
            if ($fila['bueno'] == 0) {
                $resultadoBueno = 'NO';
            } else {
                $resultadoBueno = 'SÍ';
            }
            $fecha = date_create($fila["fechaNacimiento"]);
            $fechaFormateada = date_format($fecha, 'd/m/Y');
            echo '<tr>
                        <td>' . $fila['nombre'] . '</td>
                        <td>' . $fila['apellidos'] . '</td>
                        <td class="text-center">' . $fechaFormateada . '</td>
                        <td class="text-center">' . $resultadoBueno . '</td>
                        <td class="text-center"> 
                            <form action="ninos.php" method="post">
                                <input name="modificarNino" type = "hidden" value = ' . $fila['idNino'] . '>
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </form> 
                        </td>
                        <td class="text-center"> 
                            <form action="ninos.php" method="post">
                                <input name="eliminarNino" type = "hidden" value = ' . $fila['idNino'] . '>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form> 
                        </td>
                     </tr>';
        }
        echo '</table>';
    }
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>