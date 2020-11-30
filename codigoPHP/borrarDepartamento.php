<?php
if (isset($_POST["aceptar"])) {
    header('Location: mtoDepartamento.php');
}

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
            $miBD = new PDO(HOST, USUARIO, PASS);
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_POST['aceptar'])) {
                $sql = "DELETE FROM Departamento WHERE CodDepartamento LIKE '" . $_REQUEST['codigo'] . "'"; //Los : que van delante, es para indicar que sera una consulta preparada
                $consultaBorrar = $miBD->prepare($sql);
                $consultaBorrar->bindParam(":codigo", $_REQUEST['codigo']);
                $consultaBorrar->execute();
            } else {
                $sql2 = "SELECT * FROM Departamento WHERE CodDepartamento LIKE '" . $_REQUEST['codigo'] . "'";
                $consultaSelect = $miBD->prepare($sql2);
                $consultaSelect->bindParam(':codigo', $_REQUEST["codigo"]);
                $consultaSelect->execute();
                $resultado = $consultaSelect->fetchObject();
            }
        } catch (PDOException $mensajeError) {
            echo "Error " . $mensajeError->getMessage() . "<br>";
            echo "Codigo del error " . $mensajeError->getCode() . "<br>";
            die();
        } finally {
            unset($miBD);
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <fieldset>
                <label for="codigo">Código:</label>
                <input type="text" name="codigo" disabled value="<?php echo $resultado->CodDepartamento ?>"><br><br>
                <input type="hidden" name="codigo" value="<?php echo $resultado->CodDepartamento ?>">
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" disabled  value="<?php echo $resultado->DescDepartamento ?>"><br><br>
                <input type="hidden" name="descripcion" value="<?php echo $resultado->DescDepartamento ?>">
                <label for="descripcion">Fecha Baja:</label>
                <input type="text" name="fechaBaja" disabled  value="<?php echo $resultado->DescDepartamento ?>"><br><br>
                <input type="hidden" name="fechaBaja" value="<?php echo $resultado->DescDepartamento ?>">
                <label for="volumen">Volumen de negocio:</label>
                <input type="text" name="volumen" disabled value="<?php echo $resultado->VolumenNegocio ?>"><br><br>
                <input type="hidden" name="volumen" value="<?php echo $resultado->VolumenNegocio ?>">
                <input type="submit" value="Aceptar" name="aceptar">
                <input type="submit" value="Cancelar" name="cancelar">
            </fieldset>
        </form>
    </body>
    <footer>&copy; Nerea Nuevo Pascual<a href="https://github.com/NereaNuevo13/MtoDepartamentosTema4/tree/developer" target="_blank"><img src="../webroot/images/github.png" width="40" height="40"></a></footer>
</html>