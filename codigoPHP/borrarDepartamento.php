<?php
if (isset($_POST["cancelar"])) {
    header('Location: mtoDepartamento.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mto Departamentos Tema 4l</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h2>eliminarDepartamento.php<a hreF="mtoDepartamento.php"><img src="../webroot/images/volver.png" width="70" height="40" align = "right"></a></h2>
        <?php
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once ('../config/confDB.php'); //Configuracion de la base de datos

        try {
            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consultaCodigo = "SELECT * FROM Departamento WHERE CodDepartamento = :codigo";
            $consulta = $miDB->prepare($consultaCodigo);
            $consulta->bindParam(':codigo', $_GET["codigo"]);
            $consulta->execute();
            $resultado = $consulta->fetchObject();
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            echo "Error al conectar " . "<br>";
        } finally {
            unset($miDB);
        }

        if (isset($_POST['aceptar'])) {
            try {
                // Datos de la conexión a la base de datos
                $miDB = new PDO(HOST, USUARIO, PASS);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cómo capturar las excepciones y muestre los errores
                //Crear el departamento en la base de datos    
                $sqlDepartamento = "DELETE FROM Departamento WHERE CodDepartamento = :codigo"; //Los : que van delante, es para indicar que sera una consulta preparada
                $consulta = $miDB->prepare($sqlDepartamento);
                $consulta->bindParam(":codigo", $_GET['codigo']);
                $consulta->execute();

                Header('Location: mtoDepartamento.php');
            } catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
                echo "<h3>Mensaje de ERROR</h3>";
                echo "Error: " . $mensajeError->getMessage() . "<br>";
                echo "Código de error: " . $mensajeError->getCode();
            } finally {
                unset($miDB);
            }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" name="Añadirformulario" method="POST">
            <fieldset>
                <label for="codigo">Codigo</label>
                <input type="text" name="codigo2" id="codigo2" disabled="true" value="<?php echo $resultado->CodDepartamento ?>"><br><br>
                <input type="hidden" name="codigo" id="codigo" disabled="true" value="<?php echo $resultado->CodDepartamento ?>">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" disabled="true" value="<?php echo $resultado->DescDepartamento ?>"><br><br>
                <label for="fecha">Fecha de baja</label>
                <input type="text" name="fecha" id="fecha" disabled="true" value="<?php echo $resultado->FechaBaja ?>"><br><br>
                <label for="volumen">Ventas</label>
                <input type="text" name="volumen" id="volumen" disabled="true" value="<?php echo $resultado->VolumenNegocio ?>"><br><br>
                <input type="submit" value="Eliminar" name="aceptar">
                <input type="submit" value="Cancelar" name="cancelar">
            </fieldset>
        </form>

    </body>
    <footer>&copy; Nerea Nuevo Pascual<a href="https://github.com/NereaNuevo13/MtoDepartamentosTema4/tree/developer" target="_blank"><img src="../webroot/images/github.png" width="40" height="40"></a></footer>
</html>