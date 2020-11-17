
<?php

if (isset($_POST["exportar"])) {
    header('Location: exportarDepartamentos.php');
}

if (isset($_POST["improtar"])) {
    header('Location: improtarDepartamentos.php');
}

if (isset($_POST["añadir"])) {
    header('Location: altaDepartamentos.php');
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
        <h2>Mto Departamentos - Nerea Nuevo</h2>
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
                           value="<?php if (isset($_POST['DescDepartamento'])){ echo $_POST['DescDepartamento'];} ?>">
                    <div class="acciones">
                        <input type="submit" name="enviar" value="Buscar">
                    </div>
                </div>
            </fieldset>
            <br>
            <input type="submit" name="volver" value="Volver">
        </form>
        <?php
        /**
          @author Nerea Nuevo Pascual
          @since 28/10/2020
         */
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once '../config/confDB.php'; //Configuracion de la base de datos

        //Inicializamos un array que se encargara de recoger los datos del formulario(Campos vacios)
        $arrayFormulario = [
            'DescDepartamento' => null,
        ];

        try {
            // Datos de la conexión a la base de datos
            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cómo capturar las excepciones y muestre los errores
            if (isset($_POST['enviar'])) {

                $arrayFormulario['DescDepartamento'] = $_POST['DescDepartamento'];

                $sentenciaSQL = $miDB->prepare('SELECT * FROM Departamento WHERE DescDepartamento LIKE ("%":descripcion"%")'); //Consulta SQL que queremos mostrar
                $sentenciaSQL->bindParam(":descripcion", $arrayFormulario['DescDepartamento']);
                $sentenciaSQL->execute(); //Ejecutamos la sentencia
                echo "<br>";

                if ($sentenciaSQL->rowCount() == 0) {
                    echo "<h3>No se ha encontrado ningun departamento con esa descripción</h3>";
                } else {
                    echo "<table border='0'>";
                    echo "<tr>";
                    echo "<th>Codigo</th>";
                    echo "<th>Descripción</th>";
                    echo "<th>Volumen de Negocio</th>";
                    echo "</tr>";
                    while ($registro = $sentenciaSQL->fetchObject()) { //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                        echo "<tr>";
                        echo "<td class='volumen'>$registro->CodDepartamento</td>";
                        echo "<td>$registro->DescDepartamento</td>";
                        echo "<td class='volumen'>$registro->VolumenNegocio</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
        } catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
            echo "<h3>Mensaje de ERROR</h3>";
            echo "Error: " . $mensajeError->getMessage() . "<br>";
            echo "Código de error: " . $mensajeError->getCode();
        } finally {
            unset($miDB);
        }
        ?>
    </body>
</html>