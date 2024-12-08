<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        require('../util/conexion.php');
        session_start(); 
        if(!isset($_SESSION["usuario"])) {
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        }
    ?>
</head>
<body>
    <?php
    $usuario = $_SESSION["usuario"];
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $contrasena = $_POST["contrasena"];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $_conexion -> query($sql);
        //var_dump($resultado);        
        $patron =  "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,15}$/";
        if(preg_match($patron, $contrasena)){   
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET contrasena = '$contrasena_cifrada' WHERE usuario = '$usuario'";
            $_conexion -> query($sql);
            $si = true;            
        }else{
            $err_contraseña = "Contraseña invalida";    
        }
           
    }
    ?>
    <div class="container">
        <h1>Formulario de Cambio de contraseña</h1>
        <form class="col-4" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" name="usuario" placeholder="<?php echo $usuario?>" type="text" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" name="contrasena" type="password">
                <?php if(isset($err_contraseña)) echo "<span class='text-danger'>$err_contraseña</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Cambiar contraseña">
            </div>
        </form>
        <div class="mb-3">
                <a class="btn btn-secondary" href="../productos/index.php">Volver</a>
            </div>
        <?php if(isset($si)) echo "<h2>La contraseña se ha cambiado correctamente</h2>"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>