<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAJMS-Informatica</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="background-image"></div>
    <nav>
        <ul class="menu">
            <li><a href="interfaz.html"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="cliente.php"><i class="fas fa-user"></i> Clientes</a></li>
            <li><a href="proveedores.php"><i class="fas fa-truck"></i> Proveedores</a></li>
            <li><a href="productos.php"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="venta.php"><i class="fas fa-shopping-cart"></i> Ventas</a></li>
            <li><a href="imprimir.php"><i class="fas fa-print"></i> Imprimir Venta</a></li>

        </ul>
    </nav>
    <div class="contenido">
        <h1>Gestionar Productos</h1>
            
            <?php
            include 'productos_BD.php'; // Incluye el archivo con la lógica de BD
            
            if (isset($mensaje_agregar)) {
                echo "<p>$mensaje_agregar</p>";
            }
            if (isset($error_agregar)) {
                echo "<p style='color: red;'>$error_agregar</p>";
            }
            ?>
            <form method="post">
            <h2>Agregar Producto</h2>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <br>
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" required>
                <br>
                <label>Stock:</label>
                <input type="number" name="stock" required>
                <br>
                <label>Categoría:</label>
                <select name="categoria_agregar">
                    <?php
                    // Obtener las categorías desde el archivo productos_BD.php
                    while ($categoria = mysqli_fetch_assoc($categorias_result_agregar)) {
                        echo "<option value='{$categoria['id']}'>{$categoria['nombre']}</option>";
                    }
                    ?>
                </select>
                <br>
                <label>Proveedor(RUT):</label>
                <input type="text" name="proveedor" required>
                <br>
                <input type="submit" name="agregar_producto" value="Agregar Producto">
            </form>
           
            <!-- Modificar Producto -->
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_producto'])) {
                include 'productos_BD.php'; // Incluye el archivo con la lógica de BD
            }
            if (isset($mensaje_modificar)) {
                echo "<p>$mensaje_modificar</p>";
            }
            if (isset($error_modificar)) {
                echo "<p style='color: red;'>$error_modificar</p>";
            }
            ?>
            <br>
            <form method="post">
                <h2>Modificar Producto</h2>
                <label>Nombre del Producto a Modificar:</label>
                <input type="text" name="nombre_modificar" required>
                <br>
                <label>Nuevo Nombre:</label>
                <input type="text" name="nuevo_nombre">
                <br>
                <label>Nuevo Precio:</label>
                <input type="number" step="0.01" name="nuevo_precio">
                <br>
                <label>Nuevo Stock:</label>
                <input type="number" name="nuevo_stock">
                <br>
                <label>Nueva Categoría:</label>
                <select name="nueva_categoria_modificar">
                    <?php
                    // Obtener las categorías desde el archivo productos_BD.php
                    while ($categoria = mysqli_fetch_assoc($categorias_result_modificar)) {
                        echo "<option value='{$categoria['id']}'>{$categoria['nombre']}</option>";
                    }
                    ?>
                </select>
                <br>
                <label>Nuevo Proveedor(RUT):</label>
                <input type="text" name="nuevo_proveedor">
                <br>
                <input type="submit" name="modificar_producto" value="Modificar Producto">
            </form>
            <br>
            <!-- Eliminar Producto -->
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_producto'])) {
                include 'productos_BD.php'; // Incluye el archivo con la lógica de BD
            }
            if (isset($mensaje_eliminar)) {
                echo "<p>$mensaje_eliminar</p>";
            }
            ?>
            <form method="post">
            <h2>Eliminar Producto</h2>
                <label>Nombre del Producto a Eliminar:</label>
                <input type="text" name="nombre_eliminar" required>
                <br>
                <input type="submit" name="eliminar_producto" value="Eliminar Producto">
            </form>
            <br>
            
            <form method="post">
                <h2>Mostrar Todos los Productos</h2>
                <input type="submit" name="mostrar_todos" value="Mostrar Todos los Productos">
            </form>
            <br>
            <?php
            // Mostrar Todos los Productos en una Tabla
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mostrar_todos'])) {
                $select_all_query = "SELECT * FROM productos";
                $result_all = mysqli_query($mysqli_link, $select_all_query);

                if ($result_all && mysqli_num_rows($result_all) > 0) {
                    echo"<br>";
                    echo"<form>";
                    echo "<h3>Lista de Todos los Productos:</h3>";
                    echo "<center><table border='3'>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>";
                    while ($row = mysqli_fetch_assoc($result_all)) {
                        echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['precio_actual']}</td>
                    <td>{$row['stock']}</td>
                 </tr>";
                    }
                    echo "</table></center>";
                    echo"</form";
                } else {
                    echo "<p>No se encontraron productos.</p>";
                }
            }
            ?>
            
        </div>
        
    </div>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>
</body>

</html>