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
        <h2>Bienvenid@ 
            <?php echo $_SESSION["usuario"] ?>
        </h2> 
        <a class="btn btn-danger" href="../usuario/cerrar_sesion.php">Cerrar sesión</a>
        <a class="btn btn-primary" href="../usuario/cambiar_credenciales.php" align="center">Cambiar Contraseña</a><br><br>
        <h1>Listado de producto</h1>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_producto = $_POST["id_producto"];
                $sql = "DELETE FROM productos WHERE id_producto = '$id_producto'";
                $_conexion -> query($sql);
                
            }

            $sql = "SELECT * FROM productos";
            $resultado = $_conexion -> query($sql);
        ?>
       
        <a class="btn btn-secondary" href="nuevo_producto.php">Nuevo Producto</a><br><br>
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th></th>
                    <th></th>
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
                            <img width="50" heigth="50" src="<?php echo $fila["imagen"] ?>">
                        </td>
                        <td>
                            <a class="btn btn-primary" 
                               href="editar_producto.php?id_producto=<?php echo $fila["id_producto"] ?>">Editar</a>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id_producto" value="<?php echo $fila["id_producto"] ?>">
                                <input class="btn btn-danger" type="submit" value="Borrar">
                            </form>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        
        <a class="btn btn-secondary" href="../categorias/index.php" align="center">Categorias</a><br><br>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>