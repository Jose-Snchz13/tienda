<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        require('./util/conexion.php');

        /* session_start(); */
        if(!isset($_SESSION["usuario"])) {
            ?>
            <div class="mb-3">
                <a class="btn btn-secondary" href="./usuario/iniciar_sesion.php">Iniciar Sesion</a>
            </div>
            <?php
        } 
    ?>
</head>
<body>
    <div class="container">
        <?php
            if(!isset($_SESSION["usuario"])) {
                ?>
                <h2>Bienvenid@</h2> 
                
                <?php
            } else{
                header("location: ../productos/index.php");
                exit;
            }
        ?>
        
        <h1>Listado de producto</h1>
        <?php
            
            $sql = "SELECT * FROM productos";
            $resultado = $_conexion -> query($sql);
        ?>
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($fila = $resultado -> fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["nombre"] . "</td>";
                        echo "<td>" . $fila["precio"] . "</td>";
                        echo "<td>" . $fila["categoria"] . "</td>";
                        echo "<td>" . $fila["stock"] . "</td>";                      
                        echo "<td>" . $fila["descripcion"] . "</td>";
                        ?>
                        <td>
                            <img width="50" heigth="50" src="<?php echo './productos/'.$fila["imagen"] ?>">
                        </td>
                        <?php
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>