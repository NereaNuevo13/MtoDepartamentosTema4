<?php

if (isset($_POST["cancelar"])) {
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
        <h2>añadirDepartamento.php</h2>
        <?php
        /**
          @author Nerea Nuevo Pascual
          @since 28/10/2020
         */
        
        require_once '../core/201020validacionFormularios.php'; //Importamos la libreria de validacion
        require_once ('../config/confDB.php'); //Configuracion de la base de datos

        $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
        
        //Inicializamos un array que se encargara de recoger los errores(Campos vacios)
        $arrayErrores = [
            'CodDepartamento' => null,
            'DescDepartamento' => null,
            'VolumenNegocio' => null
        ];
        
        //Inicializamos un array que se encargara de recoger los datos del formulario(Campos vacios)
        $arrayFormulario = [
            'CodDepartamento' => null,
            'DescDepartamento' => null,
            'VolumenNegocio' => null
        ];

        if (isset($_POST['enviar'])) { //Si se ha pulsado enviar

                
            $arrayErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_POST['CodDepartamento'], 3, 3, 1);  //maximo, mínimo y opcionalidad  
            
            if($arrayErrores['CodDepartamento'] == null){ // si no ha habido ningun error de validacion del campo del codigo del departamento
                try { // Bloque de código que puede tener excepciones en el objeto PDO
                    $miDB = new PDO(HOST,USUARIO,PASS); // creo un objeto PDO con la conexion a la base de datos
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establezco el atributo para la apariciopn de errores y le pongo el modo para que cuando haya un error se lance una excepcion
                        
                    $selectSQL = "SELECT CodDepartamento FROM Departamento WHERE CodDepartamento=:codDepartamento";
                    $sentenciaSQL = $miDB->prepare($selectSQL); // prepara la consulta
                    $codigoDuplicado = [':codDepartamento'=> $_POST['CodDepartamento']];
                    $sentenciaSQL->execute($codigoDuplicado); // ejecuta la consulta 
                    if($sentenciaSQL->rowCount()>0){
                        $arrayErrores['CodDepartamento']= "El código del departamento ya existe"; // meto un mensaje de error en el array de errores del codigo del departamento
                    }
                        
                }catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
                    echo "<h4>Se ha producido un error. Disculpe las molestias</h4>";
                } finally {
                    unset($miDB);
                }
            }
            
            
            $arrayErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_POST['DescDepartamento'], 255, 1, 1);  //maximo, mínimo y opcionalidad
            $arrayErrores['VolumenNegocio'] = validacionFormularios::comprobarFloat($_POST['VolumenNegocio'], 255, 0, PHP_FLOAT_MAX, 1);  //maximo, mínimo y opcionalidad
            
            foreach ($arrayErrores as $campo => $error) { //Recorre el array en busca de mensajes de error
                if ($error != null) { //Si lo encuentra vacia el campo y cambia la condiccion
                    $entradaOK = false; //Cambia la condiccion de la variable
                }
            }
           
            
        } else {
            $entradaOK = false; //Cambiamos el valor de la variable porque no se ha pulsado el botón
        }

        if ($entradaOK) { //Si el valor es true procesamos los datos que hemos recogido
        // 
            //Mostramos los datos por pantalla
            $arrayFormulario['CodDepartamento'] = strtoupper($_POST['CodDepartamento']); //Todo en mayúsculas
            $arrayFormulario['DescDepartamento'] = ucfirst($_POST['DescDepartamento']); //La primera letra en mayúscula
            $arrayFormulario['VolumenNegocio'] = ucfirst($_POST['VolumenNegocio']);
            
        try {
            // Datos de la conexión a la base de datos
            $miDB = new PDO(HOST, USUARIO, PASS);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cómo capturar las excepciones y muestre los errores
                
            //Crear el departamento en la base de datos    
            $sentenciaSQL = $miDB->prepare("INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio) VALUES (:codigo, :descripcion, :volumen);");
            $sentenciaSQL->bindParam(":codigo", $arrayFormulario['CodDepartamento']);
            $sentenciaSQL->bindParam(":descripcion", $arrayFormulario['DescDepartamento']);
            $sentenciaSQL->bindParam(":volumen", $arrayFormulario['VolumenNegocio']);
            $sentenciaSQL->execute();
            
            header('Location: mtoDepartamento.php');

        } catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
            echo "<h4>Se ha producido un error. Disculpe las molestias</h4>";
        } finally {
            unset($miDB);
        }

        } else { //Mostrar el formulario hasta que se rellene correctamente
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset>
                    <div class="obligatorio">
                        <label>Código de Departamento </label>
                        <input type = "text" name = "CodDepartamento"
                               value="<?php if($arrayErrores['CodDepartamento'] == NULL && isset($_POST['CodDepartamento'])){ echo $_POST['CodDepartamento'];} ?>"><br>
                    </div>
                    <div class="error">
                    <?php
                    if ($arrayErrores['CodDepartamento'] != NULL) {
                        echo $arrayErrores['CodDepartamento']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <br>
                    <div class="obligatorio">
                        <label>Descripción Departamento</label>
                        <input type = "text" name = "DescDepartamento"
                               value="<?php if($arrayErrores['DescDepartamento'] == NULL && isset($_POST['DescDepartamento'])){ echo $_POST['DescDepartamento'];} ?>"><br>
                    </div>
                    <div class="error">
                    <?php
                    if ($arrayErrores['DescDepartamento'] != NULL) {
                        echo $arrayErrores['DescDepartamento']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <br>
                    <div class="obligatorio">
                        <label>Volumen de Negocio</label>
                        <input type = "number" name = "VolumenNegocio"
                               value="<?php if($arrayErrores['VolumenNegocio'] == NULL && isset($_POST['VolumenNegocio'])){ echo $_POST['VolumenNegocio'];} ?>"><br>
                    </div>
                    <div class="error">
                    <?php
                    if ($arrayErrores['VolumenNegocio'] != NULL) {
                        echo $arrayErrores['VolumenNegocio']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <br>
                    <div>
                        <input type="submit" name="enviar" value="Añadir Departamento">
                        <input type="submit" name="cancelar" value="Cancelar">
                    </div>
                </fieldset>
            </form>
        <?php } ?>   
        <footer>&copy; Nerea Nuevo Pascual<a href="https://github.com/NereaNuevo13/MtoDepartamentosTema4/tree/developer" target="_blank"><img src="../webroot/images/github.png" width="40" height="40"></a></footer>
    </body>
</html>