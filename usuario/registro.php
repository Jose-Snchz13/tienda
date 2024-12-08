<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        require('../util/conexion.php');
    ?>
</head>
<body>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $patron = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9]{3,15}$/';
        if(strlen($usuario) < 2){
            $err_nombre = "Tamaño demasiado pequeño";
        }elseif(strlen($usuario) > 15){
            $err_nombre = "Tamaño demasiado grande";
        }elseif(preg_match($patron, $usuario)) {
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $_conexion -> query($sql);
            //var_dump($resultado);
            if($resultado -> num_rows == 0) {         
                $patron =  "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,15}$/";
                if(preg_match($patron, $contrasena)){   
                    $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuarios VALUES ('$usuario', '$contrasena_cifrada')";
                    $_conexion -> query($sql);
                    header("location: ../usuario/iniciar_sesion.php");
                    exit;
                }else{
                    $err_contraseña = "Contraseña invalida";    
                }
            }else{
                $err_nombre = "Ese usuario ya existe.";
            }
        }else{
            $err_nombre = "Caracteres no validos.";
        }

        
    }
    ?>
    <div class="container">
        <h1>Formulario de registro</h1>
        <form class="col-4" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" name="usuario" type="text">
                <?php if(isset($err_nombre)) echo "<span class='text-danger'>$err_nombre</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" name="contrasena" type="password">
                <?php if(isset($err_contraseña)) echo "<span class='text-danger'>$err_contraseña</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Registarse">
            </div>
        </form>
        <h3>O, si ya tienes cuenta, inicia sesión</h3>
        <a class="btn btn-secondary" href="iniciar_sesion.php">Iniciar sesión</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>