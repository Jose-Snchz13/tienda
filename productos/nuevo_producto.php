<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir nombre</title>
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
                $categoria = $_POST["categoria"];
                $stock = $_POST["stock"];
                $imagen = $_POST["imagen"];
                $descripcion = $_POST["descripcion"];
                
                

                $sql = "INSERT INTO productos 
                    (nombre, precio, categoria, stock, imagen, descripcion)
                    VALUES
                        ('$nombre', '$precio', '$categoria', '$stock'
                        , '$imagen', '$descripcion')
                ";
                $_conexion -> query($sql);
                
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
            </div>  
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" name="stock" type="text">
                <?php if(isset($err_stock)) echo "<span class='text-danger'>$err_stock</span>" ?>
            </div>  
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input class="form-control" name="imagen" type="text">
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