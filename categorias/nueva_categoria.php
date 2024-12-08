<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Categoria</title>
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
            //print_r($categorias);

            if($_SERVER["REQUEST_METHOD"] == "POST") {                
                $categoria = $_POST["categoria"];

                $patron = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,30}$/';
                if(strlen($categoria) < 2){
                    $err_nombre = "Tamaño demasiado pequeño";
                }elseif(strlen($categoria) > 30){
                    $err_nombre = "Tamaño demasiado grande";
                }elseif(preg_match($patron, $categoria)) {
                    if(!in_array($categoria,$categorias)){
                        $descripcion = $_POST["descripcion"];
                        if(strlen($descripcion) < 255){                            
                            $sql = "INSERT INTO categorias 
                                (categoria, descripcion)
                                VALUES
                                ('$categoria', '$descripcion')
                            ";
                            $_conexion -> query($sql);
                        }else{
                            $err_desc = "Tamaño demasiado grande";
                        }
                    }else{
                        $err_nombre = "No puede haber dos categorias iguales";
                    } 
                }else{
                    $err_nombre = "Categoria invalida";
                }         
                
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <input class="form-control" name="categoria" type="text">
                <?php if(isset($err_nombre)) echo "<span class='text-danger'>$err_nombre</span>" ?>
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