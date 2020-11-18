<?php

if (isset($_POST["volver"])) {
    header('Location: mtoDepartamento.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mto Departamentos Tema 4</title>
        <link rel="stylesheet" type="text/css" href="../webroot/css/estilos.css" media="screen">
    </head>
    <body>
        <h2>consultarDepartamento.php<a hreF="mtoDepartamento.php"><img src="../webroot/images/volver.png" width="70" height="40" align = "right"></a></h2>
        <?php
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once ('../config/confDB.php'); //Configuracion de la base de datos

        try {

            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //errores
            
            $mostrarSQL = $miDB->query("SELECT * FROM Departamento WHERE CodDepartamento LIKE '" . $_GET['codigo'] . "'"); //realizamos la busqueda

            echo "<table>";
            echo "<tr>";
            echo "<th>Codigo</th>";
            echo "<th>Descripción</th>";
            echo "<th>Fecha Baja</th>";
            echo "<th>Volumen de Negocio</th>";
            echo "</tr>";
            while ($registro = $mostrarSQL->fetchObject()) { //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                echo "<tr>";
                echo "<td>$registro->CodDepartamento</td>";
                echo "<td>$registro->DescDepartamento</td>";
                echo "<td>$registro->FechaBaja</td>";
                echo "<td>$registro->VolumenNegocio</td>";
                echo "</tr>";
            }
            echo "</table>";
            
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