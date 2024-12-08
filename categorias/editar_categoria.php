<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        require('../util/conexion.php');
    ?>
</head>
<body>
    <div class="container">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $categoria = $_POST["categoria"];
                $descripcion = $_POST["descripcion"];
                if(strlen($descripcion) < 255){
                    $sql = "UPDATE categorias SET
                                descripcion = '$descripcion'
                            WHERE categoria = '$categoria'";
                            $_conexion->query($sql);
                }else{
                    $err_desc = "Tamaño demasiado grande";
                }
                
            }

            $categoria = $_GET["categoria"];
            $sql = "SELECT * FROM categorias WHERE categoria = '$categoria'";
            $resultado = $_conexion->query($sql);
            $categoria_datos = $resultado->fetch_assoc();
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" name="nombre" type="text" 
                    value="<?php echo $categoria_datos['categoria']; ?>" disabled>
                <input type="hidden" name="categoria" value="<?php echo $categoria_datos['categoria'];?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion" value="<?php echo $categoria_datos['descripcion'];?>">
                <?php if(isset($err_desc)) echo "<span class='text-danger'>$err_desc</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Modificar">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>