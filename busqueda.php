<?php
include('conexion.php');
include('regalosConsultas.php');
include('ninosConsultas.php');

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
    $consultaNinos = new NinosConsultas($conexion);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $listadoNombreNinos = $consultaNinos->listadoNinos();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
if(isset($_POST['selectNinos'])){
    try {
        $listadoRegalosNino = $consultaNinos->listaRegalosNino($_POST['selectNinos']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    try {
        $listadoRegalosNinoNoSeleccionado = $consultaNinos->listaRegalosNinoNoSeleccionado($_POST['selectNinos']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    $ninoSeleccioando = $_POST['selectNinos'];
}
if(isset($_POST['addRegaloLista'])){
    try {
        $listadoRegalosNino = $consultaNinos->insertaRegaloLista($_POST['ninoListaRegalos'],$_POST['addRegaloLista']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    try {
        $listadoRegalosNino = $consultaNinos->listaRegalosNino($_POST['ninoListaRegalos']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    try {
        $listadoRegalosNinoNoSeleccionado = $consultaNinos->listaRegalosNinoNoSeleccionado($_POST['ninoListaRegalos']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    $ninoSeleccioando = $_POST['ninoListaRegalos'];
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
                            <a class="nav-link active" href="busqueda.php">Búsqueda</a>
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
                <form class="col-5 mx-auto mt-4" action="busqueda.php" method="post">
                    <label for="selectNinos" class="form-label">Selecciona un niño:</label>
                    <select id="selectNinos" name="selectNinos" class="form-select" required>
                        <?php
                        if ($listadoNombreNinos->num_rows > 0) {
                            while ($fila = $listadoNombreNinos->fetch_assoc()){
                                if($fila['idNino']==$_POST['selectNinos'] || $fila['idNino']==$_POST['ninoListaRegalos']){
                                    $selected = 'selected';
                                }else{
                                    $selected = '';
                                }
                                echo '
                                        <option '.$selected.' value="' . $fila['idNino'] . '">' . $fila['nombre'] . '</option>                          
                                    ';
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary my-3">Seleccionar</button>
                </form>
            </div>
            <div class="row" <?php if (!isset($_POST['selectNinos']) && !isset($_POST['ninoListaRegalos'])) {
                                echo "style='display: none'";
                            } ?>>
                <?php
                    tablaRegalosNino($listadoRegalosNino);
                ?>
                <form action="busqueda.php" method="post">
                    <label for="addRegaloLista" class="form-label">Selecciona un regalo:</label>
                    <select id="addRegaloLista" name="addRegaloLista" class="form-select" required>
                        <?php
                        if ($listadoRegalosNinoNoSeleccionado->num_rows > 0) {
                            while ($fila = $listadoRegalosNinoNoSeleccionado->fetch_assoc()){
                                echo '
                                    <option value="'.$fila['id'].'">' . $fila['nombre'] . ' | '. $fila['precio'].' €</option>                          
                                '; 
                            }
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ninoListaRegalos" value="<?php echo $ninoSeleccioando ?>">
                    <button type="submit" class="btn btn-success my-3">Añadir</button>
                </form>

            </div>
        </div>
        <footer>
            <!-- place footer here -->
        </footer>
        <?php
    function tablaRegalosNino($listado)
    {
        echo ' 
                    <table class="table table-striped my-5">
                        <tr>
                            <th class= "col-7">Nombre del juguete</th>
                            <th class= "col-1">Precio (€)</th>
                        </tr>';
        while ($fila = $listado->fetch_assoc()) {

            echo    '<tr>
                            <td>' . $fila['nombre'] . '</td>
                            <td>' . number_format($fila['precio'], 2, ',', '.') . '</td>
                                
                    </tr>';
        }
        echo '</table>';
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
