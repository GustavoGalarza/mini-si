<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAJMS-Informatica</title>
    <link rel="stylesheet" href="stile_interfaz.css" type="text/css" />
</head>

<body>
    <div class="background-image"></div>
    <nav>
        <ul class="menu">
            <li><a href="interfaz.html">Inicio</a></li>
            <li><a href="cliente.php">Clientes</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="venta2.php">Ventas</a></li>
        </ul>
    </nav>
    <div class="contenido">
        <h1>Gestionar Ventas</h1>
        <div class="card">
        <h2>Registro de Venta</h2>
        <?php
        if (isset($_GET['mensaje_venta'])) {
            echo "<p>Mensaje Venta: {$_GET['mensaje_venta']}</p>";
        }
        ?>
        <form action="venta2_BD.php" method="POST">
            <label for="id">ID de Venta:</label>
            <input type="text" name="id_venta" required><br>
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required><br>
            <label for="rut_cliente">RUT del Cliente:</label>
            <input type="text" name="rut_cliente" required><br>
            <input type="submit" value="Agregar Venta">
        </form>
        </div>
        <div class="card">
        <h2>Registro de Detalles de Venta</h2>
        <?php
        if (isset($_GET['mensaje_detalles_venta'])) {
            echo "<p>Mensaje Detalles Venta: {$_GET['mensaje_detalles_venta']}</p>";
        }
        ?>
        <form action="venta2_BD.php" method="POST">
            <label for="id_venta">ID de Venta:</label>
            <input type="text" name="id_venta" required><br><br>

            <label>Cantidad de Productos:</label>
            <input type="number" name="cantidad_productos" id="cantidad_productos" required><br><br>

            <table>
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="productos">
                    <!-- Contenido de la tabla se mantiene vacío inicialmente -->
                </tbody>
            </table>

            <label for="monto_total">Monto Total:</label>
            <input type="number" name="monto_total" step="0.01" required><br>

            <input type="submit" value="Agregar Detalle de Venta">
        </form>
        
        
        <h2>Actualizar Monto Final de Venta</h2>
        <?php
        if (isset($_GET['mensaje_actualizacion'])) {
            echo "<p>Mensaje actualizacion de Venta: {$_GET['mensaje_actualizacion']}</p>";
        }
        ?>
        <form action="venta2_BD.php" method="POST">
            <label for="id_venta_actualizar">ID de Venta a Actualizar:</label>
            <input type="text" name="id_venta_actualizar" required><br>
            <input type="submit" value="Actualizar Monto Final de Venta">
        </form>
        </div>

        <div class="card">
        <h2>Modificar Registro de Ventas</h2>
        <?php
        if (isset($_GET['mensaje_modificacion'])) {
            echo "<p>Mensaje modificacion de Venta: {$_GET['mensaje_modificacion']}</p>";
        }
        ?>
        <form action="venta2_BD.php" method="POST">
            <label for="id_venta_modificar">ID de Venta a Modificar:</label>
            <input type="text" name="id_venta_modificar" required><br>
            <label for="nuevo_fecha">Nueva Fecha:</label>
            <input type="date" name="nueva_fecha" required><br>
            <label for="nuevo_rut_cliente">Nuevo RUT del Cliente:</label>
            <input type="text" name="nuevo_rut_cliente" required><br>
            <input type="submit" value="Modificar Registro de Ventas">
        </form>
    </div>
        <div class="card">
        <h2>Eliminar Registro de Ventas</h2>
        <?php
        if (isset($_GET['mensaje_eliminacion'])) {
            echo "<p>Mensaje elimancion de Venta: {$_GET['mensaje_eliminacion']}</p>";
        }
        ?>
        <form action="venta2_BD.php" method="POST">
            <label for="id_venta_eliminar">ID de Venta a Eliminar:</label>
            <input type="text" name="id_venta_eliminar" required><br>
            <input type="submit" value="Eliminar Registro de Ventas">
        </form>
       </div>
        
       <div class="card">
        <h2>Mostrar Registro de Venta y Detalles de Venta</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="id_venta_mostrar">Selecciona un ID de Venta:</label>
            <select name="id_venta_mostrar" required>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
                if ($mysqli->connect_error) {
                    die("Error en la conexión: " . $mysqli->connect_error);
                }
                $sql = "SELECT id FROM venta2";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
                    }
                }
                $mysqli->close();
                ?>
            </select>
            <input type="submit" value="Mostrar Venta y Detalles">
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_venta_mostrar"])) {
            $id_venta_mostrar = $_POST["id_venta_mostrar"];

            $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
            if ($mysqli->connect_error) {
                die("Error en la conexión: " . $mysqli->connect_error);
            }

            // Consulta SQL para obtener la información de la venta
            $sql_venta = "SELECT venta2.*, clientes.nombre AS nombre_cliente FROM venta2 LEFT JOIN clientes ON venta2.rut_cliente = clientes.rut WHERE venta2.id = '$id_venta_mostrar'";
            $result_venta = $mysqli->query($sql_venta);

            if ($result_venta->num_rows > 0) {
                $row_venta = $result_venta->fetch_assoc();
                echo "<h2>Información de la Venta (ID: " . $row_venta["id"] . ")</h2>";
                echo "<p>Fecha: " . $row_venta["fecha"] . "</p>";
                echo "<p>RUT del Cliente: " . $row_venta["rut_cliente"] . "</p>";
                echo "<p>Nombre del Cliente: " . $row_venta["nombre_cliente"] . "</p>";
                echo "<p>Monto Final: $" . $row_venta["monto_final"] . "</p>";

                // Consulta SQL para obtener los detalles de venta relacionados
                $sql_detalles_venta = "SELECT * FROM detalles_venta2 WHERE id_venta = '$id_venta_mostrar'";
                $result_detalles_venta = $mysqli->query($sql_detalles_venta);

                if ($result_detalles_venta->num_rows > 0) {
                    echo "<h2>Detalles de la Venta</h2>";
                    echo "<table border='4' ";
                    echo "<tr><th>Nombre del Producto</th><th>Cantidad</th><th>Monto Total</th></tr>";
                    while ($row_detalles_venta = $result_detalles_venta->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_detalles_venta["nombre_producto"] . "</td>";
                        echo "<td>" . $row_detalles_venta["cantidad"] . "</td>";
                        echo "<td>$" . $row_detalles_venta["monto_total"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay detalles de venta para esta venta.</p>";
                }
            } else {
                echo "<p>No se encontró una venta con el ID seleccionado.</p>";
            }

            $mysqli->close();
        } else {
            echo "<p>Por favor, selecciona un ID de venta para mostrar la información.</p>";
        }
        ?>

        <script>
            // Variable para almacenar el contenido original de la tabla
            var contenidoOriginal = document.getElementById('productos').innerHTML;
            var montoTotalElement = document.querySelector('[name="monto_total"]');

            // Script para agregar filas de productos dinámicamente
            document.getElementById('cantidad_productos').addEventListener('input', function () {
                var cantidad = parseInt(this.value);
                var productosTabla = document.getElementById('productos');
                productosTabla.innerHTML = contenidoOriginal; // Restaura el contenido original

                for (var i = 0; i < cantidad; i++) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                <td>
                    <select name="nombre_producto[]" required onchange="actualizarMontoTotal()">
                        <?php
                        $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
                        if ($mysqli->connect_error) {
                            die("Error en la conexión: " . $mysqli->connect_error);
                        }
                        $sql = "SELECT nombre, precio_actual FROM productos";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["nombre"] . "' data-precio='" . $row["precio_actual"] . "'>" . $row["nombre"] . "</option>";
                            }
                        }
                        $mysqli->close();
                        ?>
                    </select>
                </td>
                <td><input type="number" name="cantidad[]" class="cantidad" required></td>
                <td><input type="number" name="monto[]" class="monto" step="0.01" readonly></td>
            `;
                    productosTabla.appendChild(row);
                }
            });

            // Función para actualizar el monto total
            function actualizarMontoTotal() {
                var filas = document.querySelectorAll('[name="nombre_producto[]"]');
                var total = 0;

                for (var i = 0; i < filas.length; i++) {
                    var select = filas[i];
                    var cantidadInput = select.parentElement.nextElementSibling.querySelector('.cantidad');
                    var montoInput = select.parentElement.nextElementSibling.nextElementSibling.querySelector('.monto');
                    var precio = parseFloat(select.options[select.selectedIndex].getAttribute('data-precio'));
                    var cantidad = parseInt(cantidadInput.value);
                    var monto = precio * cantidad;
                    total += monto;
                    montoInput.value = monto.toFixed(2);
                }

                montoTotalElement.value = total.toFixed(2);
            }
        </script>

    </div>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>
</body>

</html>