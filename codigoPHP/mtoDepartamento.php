
<?php
if (isset($_POST["exportar"])) {
    header('Location: exportarDepartamento.php');
}

if (isset($_POST["importar"])) {
    header('Location: importarDepartamento.php');
}

if (isset($_POST["añadir"])) {
    header('Location: insertarDepartamento.php');
}

if (isset($_POST["volver"])) {
    header('Location: ../../../proyectos.html');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mto Departamentos Tema 4</title>
        <link rel="stylesheet" type="text/css" href="../webroot/css/estilos.css" media="screen">
        <script src="../mostrarCodigo/script.js"></script>
    </head>
    <body>  
        <h2>Mto Departamentos - Nerea Nuevo<a hreF="../../../../proyectos.html"><img src="../webroot/images/volver.png" width="70" height="40" align = "right"></a></h2>
        <div class="formulario">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset id="bodi">
                    <div class="obligatorio">
                        <div class="acciones">
                            <input type="submit" name="exportar" value="Exportar">
                            <input type="submit" name="importar" value="Importar">
                            <input type="submit" name="añadir" value="Añadir">
                        </div>
                        <br><br><br>
                        <label>Descripción</label>
                        <input type = "text" name = "DescDepartamento"
                               value="<?php if (isset($_POST['DescDepartamento'])) {echo $_POST['DescDepartamento'];} ?>">
                        <div class="acciones">
                            <input type="submit" name="enviar" value="Buscar">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
        /**
          @author Nerea Nuevo Pascual
          @since 28/10/2020
         */
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once '../config/confDB.php'; //Configuracion de la base de datos
        //Inicializamos un array que se encargara de recoger los datos del formulario(Campos vacios)

        try {
            // Datos de la conexión a la base de datos
            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cómo capturar las excepciones y muestre los errores

            $descripcionBuscada = "";
            if (isset($_POST['DescDepartamento'])) {
                $descripcionBuscada = $_POST['DescDepartamento'];
            }

            $sql = 'SELECT * FROM Departamento WHERE DescDepartamento LIKE "%":DescDepartamento"%"';
            $sentenciaSQL = $miDB->prepare($sql); // preparo la consulta
            $parametros = [":DescDepartamento" => $descripcionBuscada];
            $sentenciaSQL->execute($parametros); // ejecuto la consulta con los paremtros del array de parametros

            if ($sentenciaSQL->rowCount() == 0) {
                echo "<h3>No se ha encontrado ningun departamento con esa descripción</h3>";
            } else {
                echo "<table border='0'>";
                echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Descripción</th>";
                echo "<th>Fecha Baja</th>";
                echo "<th>Volumen de Negocio</th>";
                echo "<th>Opciones</th>";
                echo "</tr>";
                while ($registro = $sentenciaSQL->fetchObject()) { //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                    echo "<tr>";
                    echo "<td class='volumen'>$registro->CodDepartamento</td>";
                    echo "<td>$registro->DescDepartamento</td>";
                    echo "<td class='volumen'>$registro->FechaBaja</td>";
                    echo "<td class='volumen'>$registro->VolumenNegocio</td>";
                    echo "<td class='emojis'>";
                    echo "<a href='consultarDepartamento.php?codigo=$registro->CodDepartamento''><img src='../webroot/images/ver.png' width='30' heigth='30'></a>";
                    echo "<a href='editarDepartamento.php?codigo=$registro->CodDepartamento'><img src='../webroot/images/editar.png' width='30' heigth='30'></a>";
                    echo "<a href='borrarDepartamento.php?codigo=$registro->CodDepartamento'><img src='../webroot/images/borrar.png' width='30' heigth='30'></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
            echo "<h3>Mensaje de ERROR</h3>";
            echo "Error: " . $mensajeError->getMessage() . "<br>";
            echo "Código de error: " . $mensajeError->getCode();
        } finally {
            unset($miDB);
        }
        ?>
        <footer>&copy; Nerea Nuevo Pascual<a href="https://github.com/NereaNuevo13/MtoDepartamentosTema4/tree/developer" target="_blank"><img src="../webroot/images/github.png" width="40" height="40"></a></footer>
    </body>
</html>