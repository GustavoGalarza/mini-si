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
        <h1>Gestionar Proveedores</h1>
        
           
            <?php
            include 'proveedores_BD.php'; // Incluye el archivo con la lógica de BD
            
            if (isset($mensaje_agregar)) {
                echo "<p>$mensaje_agregar</p>";
            }
            if (isset($error_agragar)) {
                echo "<p style='color: red;'>$error_agregar</p>";
            }
            ?>
            <form method="post"> 
                <h2>Agregar Proveedor</h2>
                <label>RUT:</label>
                <input type="text" name="rut" required>
                <br>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <br>
                <label>Dirección Calle:</label>
                <input type="text" name="direccion_calle" required>
                <br>
                <label>Dirección Número:</label>
                <input type="text" name="direccion_numero" required>
                <br>
                <label>Dirección Comuna:</label>
                <input type="text" name="direccion_comuna" required>
                <br>
                <label>Dirección Ciudad:</label>
                <input type="text" name="direccion_ciudad" required>
                <br>
                <label>Teléfono:</label>
                <input type="text" name="telefono" required>
                <br>
                <label>Página Web:</label>
                <input type="text" name="pagina_web" required>
                <br>
                <input type="submit" name="agregar_proveedor" value="Agregar Proveedor">
            </form>
        
            <!-- Modificar Proveedor -->
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_proveedor'])) {
                include 'proveedores_BD.php'; // Procesa el formulario de modificar en la misma página
            }
            if (isset($mensaje_modificar)) {
                echo "<p>$mensaje_modificar</p>";
            }
            if (isset($error_modificar)) {
                echo "<p style='color: red;'>$error_modificar</p>";
            }
            ?>
            <form method="post">
                <h2>Modificar Proveedor</h2>
                <label>RUT del Proveedor a Modificar:</label>
                <input type="text" name="rut_modificar" required>
                <br>
                <label>Nombre Nuevo:</label>
                <input type="text" name="nuevo_nombre">
                <br>
                <label>Dirección Calle(nuevo):</label>
                <input type="text" name="nuevo_direccion_calle" required>
                <br>
                <label>Dirección Número(nuevo):</label>
                <input type="text" name="nuevo_direccion_numero" required>
                <br>
                <label>Dirección Comuna(nuevo):</label>
                <input type="text" name="nuevo_direccion_comuna" required>
                <br>
                <label>Dirección Ciudad(nuevo):</label>
                <input type="text" name="nuevo_direccion_ciudad" required>
                <br>
                <label>Teléfono(nuevo):</label>
                <input type="text" name="nuevo_telefono" required>
                <br>
                <label>Página Web(nuevo):</label>
                <input type="text" name="nuevo_pagina_web" required>
                <br>
                <input type="submit" name="modificar_proveedor" value="Modificar Proveedor">
            </form>
        
            <!-- Eliminar Proveedor -->
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_proveedor'])) {
                include 'proveedores_BD.php'; // Procesa el formulario de eliminar en la misma página
            }
            if (isset($mensaje_eliminar)) {
                echo "<p>$mensaje_eliminar</p>";
            }
            if (isset($error_eliminar)) {
                echo "<p style='color: red;'>$error_eliminar</p>";
            }
            ?>
            <form method="post">
                <h2>Eliminar Proveedor</h2>
                <label>RUT del Proveedor a Eliminar:</label>
                <input type="text" name="rut_eliminar" required>
                <br>
                <input type="submit" name="eliminar_proveedor" value="Eliminar Proveedor">
            </form>
        
            <!-- Mostrar Proveedores -->
            <br>
            <form method="post">
                <h2>Mostrar Proveedores</h2>
                <input type="submit" name="mostrar_proveedores" value="Mostrar Proveedores">
            </form>
            <?php
            // Si se envió el formulario para mostrar proveedores
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mostrar_proveedores'])) {
                // Consulta para mostrar la tabla de proveedores
                $mostrar_query = "SELECT * FROM proveedores";
                $resultado_mostrar = $mysqli->query($mostrar_query);

                if ($resultado_mostrar->num_rows > 0) {
                    echo "<br>";
                    echo "<form>";
                    echo "<table border='1'>
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Dirección Calle</th>
                    <th>Dirección Número</th>
                    <th>Dirección Comuna</th>
                    <th>Dirección Ciudad</th>
                    <th>Teléfono</th>
                    <th>Página Web</th>
                </tr>";
                    while ($fila = $resultado_mostrar->fetch_assoc()) {
                        echo "<tr>
                    <td>" . $fila['rut'] . "</td>
                    <td>" . $fila['nombre'] . "</td>
                    <td>" . $fila['direccion_calle'] . "</td>
                    <td>" . $fila['direccion_numero'] . "</td>
                    <td>" . $fila['direccion_comuna'] . "</td>
                    <td>" . $fila['direccion_ciudad'] . "</td>
                    <td>" . $fila['telefono'] . "</td>
                    <td>" . $fila['pagina_web'] . "</td>
                </tr>";
                    }
                    echo "</table>";
                    echo "</form>";
                } else {
                    echo "No se encontraron resultados.";
                }
            }
            $mysqli->close();
            ?>
            
        </div>

    </div>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>
</body>

</html>