<?php
include('conexion.php');
include('regalosConsultas.php');
include('reyesMagosConsultas.php');
try {
    $conexionC = new Conexion;
    $conexion = $conexionC->connectarBD();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $consultaRegalos = new RegalosConsultas($conexion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $consultaReyesMagos = new ReyesMagosConsultas($conexion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
if (isset($_POST['nombreRegalo'])) {
    try {
        $consultaRegalos->insertarRegalo($_POST['nombreRegalo'], $_POST['precioRegalo'], $_POST['reyMago']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['eliminarRegalo'])) {
    try {
        $consultaRegalos->eliminarRegalo($_POST['eliminarRegalo']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['modificarRegalo'])){
    try {
        $datosRegalo =$consultaRegalos->datosRegalo($_POST['modificarRegalo']);
        if ($datosRegalo->num_rows > 0) {
            $fila = $datosRegalo->fetch_assoc();
            $idModRegalo = $fila['idRegalos'];
            $nombreModRegalo = $fila['nombre'];
            $precioModRegalo = $fila['precio'];
            $idModReyMago = $fila['idReyMagoFK'];
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
if(isset($_POST['nombreRegaloMod'])){
    try{
        $consultaRegalos->modificarRegalo($_POST['idRegaloMod'],$_POST['nombreRegaloMod'],$_POST['precioRegaloMod'],$_POST['reyMagoMod']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
try {
    $listadoRegalos = $consultaRegalos->listadoRegalos();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $listadoReyesMagos = $consultaReyesMagos->listadoReyesMagos();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
mysqli_close($conexion);    //cerrar conexión con el servidor
?>

<!doctype html>
<html lang="en">

<head>
    <title>Regalos</title>
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
                            <a class="nav-link " href="ninos.php">Niños</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="regalos.php">Regalos</a>
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
            if ($listadoRegalos->num_rows > 0) {
                tablaRegalos($listadoRegalos);
            }
            ?>
        </div>

        <div class="row" <?php if (isset($_POST['modificarRegalo'])) {
                                echo "style='display: none'";
                            } ?>>
            <h2 class="text-center">Añadir un regalo a la lista</h2>
            <form class="col-8 mx-auto" action="regalos.php" method="post" id="addRegalo">
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="nombreRegalo" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombreRegalo" name="nombreRegalo" required>
                    </div>
                    <div class="col-2">
                        <label for="precioRegalo" class="form-label">Precio:</label>
                        <input type="number" step="0.01" class="form-control" id="precioRegalo" name="precioRegalo" required>
                    </div>
                    <div class="col-3">
                        <label for="reyMago" class="form-label">Rey Mago</label>
                        <select id="reyMago" name="reyMago" class="form-select" required>
                            <?php
                            if ($listadoReyesMagos->num_rows > 0 && !isset($_POST['modificarRegalo'])) {
                                while ($fila = $listadoReyesMagos->fetch_assoc()){
                                    echo '
                                            <option value="' . $fila['idReyMago'] . '">' . $fila['nombre'] . '</option>                          
                                        ';
                            
                                }
                            }
                            ?>
                        </select>
                    </div>

                </div>

            </form>
            <form action="regalos.php" id="cancelarAddRegalo"></form>
            <div class="col-8 mx-auto">
                <button type="submit" class="btn btn-success col-5 m-2" form="addRegalo">Añadir regalo</button>
                <button type="submit" class="btn btn-danger col-5 m-2" form="cancelarAddRegalo">Cancelar</button>
            </div>
        </div>

        <div class="row" <?php if (isset($_POST['modificarRegalo'])) {
                                echo "style=''";
                            } else {
                                echo "style='display:none'";
                            } ?>>
            <h2 class="text-center">Modificar Regalo: <?php echo $nombreModRegalo ?></h2>
            <form class="col-8 mx-auto" action="regalos.php" method="post" id="modRegalo">
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="nombreRegalo" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombreRegalo" name="nombreRegaloMod" required value="<?php echo $nombreModRegalo ?>">
                    </div>
                    <div class="col-2">
                        <label for="precioRegalo" class="form-label">Precio:</label>
                        <input type="number" step="0.01" class="form-control" id="precioRegalo" name="precioRegaloMod" value="<?php echo $precioModRegalo ?>" required>
                    </div>
                    <div class="col-3">
                        <label for="reyMago" class="form-label">Rey Mago</label>
                        <select id="reyMago" name="reyMagoMod" class="form-select" required>
                            <?php
                            if ($listadoReyesMagos->num_rows > 0 && isset($_POST['modificarRegalo'])) {
                                while ($fila = $listadoReyesMagos->fetch_assoc()){
                                    if($fila['idReyMago']==$idModReyMago){
                                        $selected = 'selected';
                                    }else{
                                        $selected = '';
                                    }
                                    
                                    echo '
                                            <option value="' . $fila['idReyMago'] . '" '.$selected.'>' . $fila['nombre'] . '</option>                          
                                        ';
                                }
                            
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="idRegaloMod" value="<?php echo $idModRegalo ?>">

                </div>

            </form>
            <form action="regalos.php" id="cancelarAddRegalo"></form>
            <div class="col-8 mx-auto">
                <button type="submit" class="btn btn-success col-5 m-2" form="modRegalo">Modificar regalo</button>
                <button type="submit" class="btn btn-danger col-5 m-2" form="cancelarAddRegalo">Cancelar</button>
            </div>
        </div>
    </div>

    <?php
    function tablaRegalos($listado)
    {
        echo ' 
                    <table class="table table-striped my-5">
                        <tr>
                            <th class= "col-7">Nombre del juguete</th>
                            <th class= "col-1">Precio (€)</th>
                            <th class= "col-1">Rey Mago</th>
                            <th class="text-center col-1">Eliminar</th>
                            <th class="text-center col-1">Modificar</th>
                        </tr>';
        while ($fila = $listado->fetch_assoc()) {

            echo    '<tr>
                                <td>' . $fila['nombre'] . '</td>
                                <td>' . number_format($fila['precio'], 2, ',', '.') . '</td>
                                <td>' . $fila['reyMago'] . '</td>
                                <td class="text-center"> 
                                    <form action="regalos.php" method="post">
                                        <input name="modificarRegalo" type = "hidden" value = ' . $fila['id'] . '>
                                        <button type="submit" class="btn btn-primary">Modificar</button>
                                    </form> 
                                </td>
                                <td class="text-center"> 
                                    <form action="regalos.php" method="post">
                                        <input name="eliminarRegalo" type = "hidden" value = ' . $fila['id'] . '>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form> 
                                </td>
                            </tr>';
        }
        echo '</table>';
    }
    ?>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>