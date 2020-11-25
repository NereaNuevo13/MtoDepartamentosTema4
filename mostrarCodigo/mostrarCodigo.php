<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">		
        <title></title>
    </head>

    <body>
        <?php
        /*
         * Author: Nerea Nuevo Pascual
         */
        
        echo "<h3>Fichero de Configuracion</h3>";
        highlight_file("../config/confDB.php");
        
        echo "<h3>mtoDepartamento.php</h3>";
        highlight_file("../codigoPHP/mtoDepartamento.php");

        echo "<h3>consultarDepartamento.php</h3>";
        highlight_file("../codigoPHP/consultarDepartamento.php");
        
        echo "<h3>insertarDepartamento.php</h3>";
        highlight_file("../codigoPHP/insertarDepartamento.php");
        
        echo "<h3>editarDepartamento.php</h3>";
        highlight_file("../codigoPHP/editarDepartamento.php");
        
        echo "<h3>borrarDepartamento.php</h3>";
        highlight_file("../codigoPHP/borrarDepartamento.php");
        ?>
    </body>
</html>
