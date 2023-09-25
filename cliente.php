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
        <h1>Gestionar Clientes</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_cliente'])) {
            include 'cliente_BD.php';
        }

        if (isset($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        if (isset($error)) {
            echo "<p style='color: red;'>$error</p>";
        }
        ?>
    <br>
        <form method="post" action="cliente.php">
            <h2>Agregar Cliente</h2>
            <label>RUT:</label>
            <input type="text" name="rut" required>
            <br>
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
            <br>
            <label>Calle:</label>
            <input type="text" name="calle" required>
            <br>
            <label>Número:</label>
            <input type="text" name="numero" required>
            <br>
            <label>Comuna:</label>
            <input type="text" name="comuna" required>
            <br>
            <label>Ciudad:</label>
            <input type="text" name="ciudad" required>
            <br>
            <label>Telefonos (separados por coma):</label>
            <input type="text" name="telefonos">
            <br>
            <input type="submit" name="agregar_cliente" value="Agregar Cliente">
        </form>


        <br>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_cliente'])) {
            include 'cliente_BD.php'; // Procesa el formulario de modificar en la misma página
        }
        if (isset($mensaje_modificar)) {
            echo "<p>$mensaje_modificar</p>";
        }
        if (isset($error_modificar)) {
            echo "<p style='color: red;'>$error_modificar</p>";
        }
        ?>
        <form method="post" action="cliente.php">
            <h2>Modificar Cliente</h2>
            <label>RUT del Cliente a Modificar:</label>
            <input type="text" name="rut_modificar" required>
            <br>
            <label>Nombre Nuevo:</label>
            <input type="text" name="nuevo_nombre" required>
            <br>
            <label>Calle Nueva:</label>
            <input type="text" name="nueva_calle" required>
            <br>
            <label>nuevo Número:</label>
            <input type="text" name="nuevo_numero" required>
            <br>
            <label>Nueva Comuna:</label>
            <input type="text" name="nueva_comuna" required>
            <br>
            <label>Nueva Ciudad:</label>
            <input type="text" name="nueva_ciudad" required>
            <br>
            <label>nuevos_Telefonos (separados por coma):</label>
            <input type="text" name="nuevos_telefonos">
            <br>

            <input type="submit" name="modificar_cliente" value="Modificar Cliente">
        </form>
        <br>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_cliente'])) {
            include 'cliente_BD.php'; // Procesa el formulario de eliminar en la misma página
        }
        if (isset($mensaje_eliminar)) {
            echo "<p>$mensaje_eliminar</p>";
        }
        if (isset($error_eliminar)) {
            echo "<p style='color: red;'>$error_eliminar</p>";
        }
        ?>
        <form method="post" action="cliente.php">
            <h2>Eliminar Cliente</h2>
            <label>RUT del Cliente a Eliminar:</label>
            <input type="text" name="rut_eliminar" required>
            <br>
            <input type="submit" name="eliminar_cliente" value="Eliminar Cliente">
        </form>


        
        <br>
        <form method="post" action="cliente.php">
            <h2>Mostrar Clientes</h2>
            <input type="submit" name="mostrar_clientes" value="Mostrar Clientes">
        </form>
<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mostrar_clientes'])) {
            include 'cliente_BD.php'; // Procesa el formulario de mostrar en la misma página
            if (isset($clientes)) {
                echo "<br>";
                echo "<form>";
                echo "<table border='1'  >
                <tr>
                
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Calle</th>
                    <th>Número</th>
                    <th>Comuna</th>
                    <th>Ciudad</th>
                    <th>Teléfonos</th>
                </tr>";
                foreach ($clientes as $cliente) {
                    echo "<tr>
                    <td>" . $cliente['rut'] . "</td>
                    <td>" . $cliente['nombre'] . "</td>
                    <td>" . $cliente['direccion_calle'] . "</td>
                    <td>" . $cliente['direccion_numero'] . "</td>
                    <td>" . $cliente['direccion_comuna'] . "</td>
                    <td>" . $cliente['direccion_ciudad'] . "</td>
                    <td>";
                    // Mostrar teléfonos del cliente
                    foreach ($cliente['telefonos'] as $telefono) {
                        echo $telefono . "<br>";
                    }
                    echo "</td></tr>";
                }
                echo "</table>";
                echo "</form";
            }
        }
        ?>


    </div>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>

</body>

</html>