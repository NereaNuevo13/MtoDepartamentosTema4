<?php
if (isset($_POST["Modificar"])) {
    header('Location: mtoDepartamento.php');
}

if (isset($_POST["cancelar"])) {
    header('Location: mtoDepartamento.php');
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mto Departamentos Tema 4</title>    
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h2>editarDepartamento.php<a hreF="mtoDepartamento.php"><img src="../webroot/images/volver.png" width="70" height="40" align = "right"></a></h2>
        <?php
        /*
          @author: Nerea Nuevo Pascual
          @since: 21/11/2019
         */
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once ('../config/confDB.php'); //Configuracion de la base de datos
        $entradaOK = true;
        try {
            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consultaCodigo = "SELECT * FROM Departamento WHERE CodDepartamento LIKE '" . $_GET['codigo'] . "'";
            $consulta = $miDB->prepare($consultaCodigo);
            $consulta->bindParam(':codigo', $_GET["codigo"]);
            $consulta->execute();
            $resultado = $consulta->fetchObject();

            /* while ($resultado = $consulta->fetchObject()) {
              echo $resultado->CodDepartamento;
              echo $resultado->DescDepartamento;
              echo $resultado->FechaBaja;
              echo $resultado->VolumenNegocio;
              } */
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            echo "Error al conectar " . "<br>";
        } finally {
            unset($miDB);
        }


        if (isset($_REQUEST['Modificar'])) {
            $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_POST['descripcion'], 255, 1, 1);
            $aErrores['volumen'] = validacionFormularios::comprobarFloat($_POST['volumen'], PHP_FLOAT_MAX, 0, 1);
            foreach ($aErrores as $key => $value) {
                if ($value != null) {
                    $entradaOK = false;
                }
            }
        }
        if ($entradaOK == true && isset($_REQUEST['Modificar'])) {
            try {
                $miDB = new PDO(HOST, USUARIO, PASS);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sqlDepartamento = 'UPDATE Departamento SET DescDepartamento=:desc,VolumenNegocio=:volumen WHERE CodDepartamento=:codigo';
                $aDatos = [":codigo" => $_REQUEST['codigo'], ":desc" => $_REQUEST['descripcion'], ":volumen" => $_REQUEST['volumen']];
                $consulta = $miDB->prepare($sqlDepartamento);
                $consulta->execute($aDatos);
            } catch (PDOException $exc) {
                echo $exc->getMessage();
                echo "Error al conectar " . "<br>";
            } finally {
                unset($miDB);
            }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" name="Añadirformulario" method="POST">
            <fieldset>
                <label for="codigo">Codigo</label>
                <input type="text" name="codigo2" id="codigo2" disabled="true" value="<?php echo $resultado->CodDepartamento ?>"><br><br>
                <input type="hidden" name="codigo" id="codigo" value="<?php echo $resultado->CodDepartamento ?>">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" value="<?php echo $resultado->DescDepartamento ?>"><br><br>
                <label for="fecha">Fecha de baja</label>
                <input type="text" name="fecha" id="fecha" disabled="true" value="<?php echo $resultado->FechaBaja; ?>"><br><br>
                <label for="volumen">Ventas</label>
                <input type="text" name="volumen" id="volumen" value="<?php echo $resultado->VolumenNegocio ?>"><br><br>
                <input type="submit" value="Aceptar" name="Modificar">
                <input type="submit" value="Cancelar" name="cancelar">
            </fieldset>
        </form>
        <footer>&copy; Nerea Nuevo Pascual<a href="https://github.com/NereaNuevo13/MtoDepartamentosTema4/tree/developer" target="_blank"><img src="../webroot/images/github.png" width="40" height="40"></a></footer>
    </body>
</html> 