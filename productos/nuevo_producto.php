<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto</title>
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
    <div class="container">
        <?php
            $sql = "SELECT * FROM categorias ORDER BY categoria";
            $resultado = $_conexion -> query($sql);
            $categorias = [];

            //var_dump($resultado);

            while($fila = $resultado -> fetch_assoc()) {
                array_push($categorias, $fila["categoria"]);
            }

            $sql = "SELECT * FROM productos ORDER BY id_producto";
            $resultado = $_conexion -> query($sql);
            $productos = [];

            //var_dump($resultado);

            while($fila = $resultado -> fetch_assoc()) {
                array_push($productos, $fila["id_producto"]);
            }
            //print_r($productos);
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {        
                $nombre = $_POST["nombre"];
                $precio = $_POST["precio"];  
                $categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : ""; 
                $stock = $_POST["stock"];
                $descripcion = $_POST["descripcion"];

                $direccion_temporal = $_FILES["imagen"]["tmp_name"];
                $nombre_imagen = $_FILES["imagen"]["name"];
                move_uploaded_file($direccion_temporal, "../imagenes/$nombre_imagen");

                $patron = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{2,30}$/';
                if(strlen($nombre) < 2){
                    $err_nombre = "El nombre es demasiado pequeño";
                }elseif(strlen($nombre) > 30){
                    $err_nombre = "El nombre es demasiado grande";
                }elseif(preg_match($patron, $nombre)) {
                    if(!is_numeric($precio) || (float)$precio != $precio) {
                            $err_precio = "El precio debe ser un número decimal.";
                        } else {                            
                            if ($precio < 0 || $precio > 9999.99) {
                                $err_precio = "El precio debe estar entre 0 y 9999.99.";
                            }else{
                                if(strlen($descripcion) < 255){    
                                    if(!is_numeric($stock) || (int)$stock != $stock) {
                                        $err_stock = "El stock debe ser un número entero.";
                                    } else {                            
                                        if ($stock < 0 || $stock > 2147483646) {
                                            $err_stock = "El stock debe estar entre 0. Y no superior a nuestra capacidad.";
                                        }else{
                                            if (empty($categoria)) {
                                                $err_categoria = "Debes seleccionar una categoría.";
                                            } else{
                                                $sql = "INSERT INTO productos 
                                                    (nombre, precio, categoria, stock, imagen, descripcion)
                                                    VALUES
                                                        ('$nombre', '$precio', '$categoria', '$stock'
                                                        , '../imagenes/$nombre_imagen', '$descripcion')
                                                ";
                                                $_conexion -> query($sql);
                                            }
                                        }
                                    }     
                                }else{
                                    $err_desc = "Tamaño demasiado grande";
                                }
                            }
                        }                        
                }else{
                    $err_nombre = "Caracteres invalidos en el nombre";
                }

                
                
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" name="nombre" type="text">
                <?php if(isset($err_nombre)) echo "<span class='text-danger'>$err_nombre</span>" ?>
            </div>  
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" name="precio" type="text">
                <?php if(isset($err_precio)) echo "<span class='text-danger'>$err_precio</span>" ?>
            </div>     
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select class="form-select" name="categoria">
                    <option value="" selected disabled hidden>--- Elige una categoria ---</option>
                    <?php foreach($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria ?>">
                            <?php echo $categoria ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if(isset($err_categoria)) echo "<span class='text-danger'>$err_categoria</span>" ?>
            </div>  
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" name="stock" type="text">
                <?php if(isset($err_stock)) echo "<span class='text-danger'>$err_stock</span>" ?>
            </div>  
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input class="form-control" name="imagen" type="file">
                <?php if(isset($err_imagen)) echo "<span class='text-danger'>$err_imagen</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input class="form-control" name="descripcion" type="text">
                <?php if(isset($err_desc)) echo "<span class='text-danger'>$err_desc</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Crear">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>