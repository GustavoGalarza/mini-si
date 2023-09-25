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
        <h1>Formularios de Gestion de Ventas</h1>
        <?php
        if (isset($_GET['mensaje_venta'])) {
            echo "<p>Mensaje Venta: {$_GET['mensaje_venta']}</p>";
        }
        ?>
        <!-- Formulario para agregar una nueva venta y detalle de venta -->
        <form action="venta_BD.php" method="POST">
            <h2>Agregar Venta</h2>
            <label for="id_venta">ID Venta:</label>
            <input type="text" name="id_venta" required><br>
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required><br>
            <label for="rut_cliente">RUT Cliente:</label>
            <input type="text" name="rut_cliente" required><br>
            <label for="monto_final">Monto Final:</label>
            <input type="text" name="monto_final" id="monto_final" readonly><br>
            <label for="descuento">Descuento (%):</label>
            <input type="text" name="descuento" id="descuento" required>
            <h3>Detalles de la Venta</h3>
            <table id="detalle_venta_table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Monto Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button type="button" id="agregar_producto_btn">Agregar Producto</button>

            <input type="submit" name="agregar_venta" value="Agregar Venta y Detalle de Venta">
        </form>


        <?php
        if (isset($_GET['mensaje_modificar'])) {
            echo "<p>Mensaje de modificacion: {$_GET['mensaje_modificar']}</p>";
        }
        ?>
        <br>
        <!-- Formulario para modificar una venta existente -->
        <form action="venta_BD.php" method="POST">
            <h2>Modificar Venta</h2>
            <label for="nueva_id_venta">ID Venta a modificar:</label>
            <input type="text" name="id_venta_modificar" required><br>
            <label for="nueva_fecha">Nueva Fecha:</label>
            <input type="date" name="nueva_fecha" required><br>
            <label for="nuevo_rut_cliente">Nuevo RUT Cliente:</label>
            <input type="text" name="nuevo_rut_cliente" required><br>
            <label for="nuevo_monto_final">Nuevo Monto Final:</label>
            <input type="text" name="nuevo_monto_final" id="nuevo_monto_final" readonly><br>
            <label for="nuevo_descuento">Nuevo Descuento (%):</label>
            <input type="text" name="nuevo_descuento" id="nuevo_descuento" required>
            <h3>Detalles de la Venta</h3>
            <table id="detalle_venta_table_modificar">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Monto Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button type="button" id="agregar_producto_btn_modificar">Agregar Producto</button>

            <input type="submit" name="modificar_venta" value="Modificar Venta y Detalle de Venta">
        </form>


        <?php
        if (isset($_GET['mensaje_eliminar'])) {
            echo "<p>Mensaje de eliminacion: {$_GET['mensaje_eliminar']}</p>";
        }
        ?>
        <br>
        <form action="venta_BD.php" method="POST">
            <h2>Eliminar Venta</h2>
            <label for="eliminar_id_venta">ID Venta a eliminar:</label>
            <input type="text" name="eliminar_id_venta" required><br>
            <input type="submit" name="eliminar_venta" value="Eliminar Venta y Detalles de Venta">
        </form>


        <!-- Formulario para mostrar venta y detalles -->

        <br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <h2>Mostrar Registro de Venta y Detalles de Venta</h2>
            <label for="venta_mostrar">Selecciona un ID de Venta:</label>
            <select name="venta_mostrar" required>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
                if ($mysqli->connect_error) {
                    die("Error en la conexión: " . $mysqli->connect_error);
                }
                $sql = "SELECT id FROM venta";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
                    }
                }
                $mysqli->close();
                ?>
            </select>
            <input type="submit" name="mostrar_venta" value="Mostrar Venta y Detalles">
        </form>

        <!-- Botón para mostrar todas las ventas -->

        <br>
        <form class="form_de_todos" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="todas_las_ventas" value="1">
            <input type="submit" value="Mostrar Todas las Ventas">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
            if ($mysqli->connect_error) {
                die("Error en la conexión: " . $mysqli->connect_error);
            }

            // Mostrar todas las ventas de todos los clientes
            if (isset($_POST["todas_las_ventas"])) {
                $sql_todas_las_ventas = "SELECT venta.*, clientes.nombre AS nombre_cliente, clientes.direccion_calle, clientes.direccion_numero, clientes.direccion_comuna, clientes.direccion_ciudad, GROUP_CONCAT(telefonos_clientes.telefono SEPARATOR ', ') AS telefonos FROM venta LEFT JOIN clientes ON venta.rut_cliente = clientes.rut LEFT JOIN telefonos_clientes ON clientes.rut = telefonos_clientes.rut_cliente GROUP BY venta.id";
                $result_todas_las_ventas = $mysqli->query($sql_todas_las_ventas);

                if ($result_todas_las_ventas->num_rows > 0) {

                    echo "<br>";
                    echo "<form>";
                    echo "<h2>Todas las Ventas</h2>";
                    echo "<table border='1'>";
                    echo "<tr><th>ID de Venta</th><th>Fecha</th><th>RUT del Cliente</th><th>Nombre del Cliente</th><th>Dirección Calle</th><th>Dirección Número</th><th>Dirección Comuna</th><th>Dirección Ciudad</th><th>Monto Final</th><th>Descuento</th><th>Teléfonos</th></tr>";
                    while ($row_venta = $result_todas_las_ventas->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_venta["id"] . "</td>";
                        echo "<td>" . $row_venta["fecha"] . "</td>";
                        echo "<td>" . $row_venta["rut_cliente"] . "</td>";
                        echo "<td>" . $row_venta["nombre_cliente"] . "</td>";
                        echo "<td>" . $row_venta["direccion_calle"] . "</td>"; // Nuevo atributo de clientes
                        echo "<td>" . $row_venta["direccion_numero"] . "</td>"; // Nuevo atributo de clientes
                        echo "<td>" . $row_venta["direccion_comuna"] . "</td>"; // Nuevo atributo de clientes
                        echo "<td>" . $row_venta["direccion_ciudad"] . "</td>"; // Nuevo atributo de clientes
                        echo "<td>$" . $row_venta["monto_final"] . "</td>";
                        echo "<td>" . $row_venta["descuento"] . "%</td>";
                        echo "<td>" . $row_venta["telefonos"] . "</td>"; // Números de teléfono concatenados
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</form>";
                } else {
                    echo "<p>No hay ventas registradas.</p>";
                }
            }

            // Mostrar detalles de una venta específica
            if (isset($_POST["venta_mostrar"])) {
                $id_venta_mostrar = $_POST["venta_mostrar"];

                // Consulta SQL para obtener la información de la venta
                $sql_venta = "SELECT venta.*, clientes.nombre AS nombre_cliente, clientes.direccion_calle, clientes.direccion_numero, clientes.direccion_comuna, clientes.direccion_ciudad, GROUP_CONCAT(telefonos_clientes.telefono SEPARATOR ', ') AS telefonos FROM venta LEFT JOIN clientes ON venta.rut_cliente = clientes.rut LEFT JOIN telefonos_clientes ON clientes.rut = telefonos_clientes.rut_cliente WHERE venta.id = '$id_venta_mostrar' GROUP BY venta.id";
                $result_venta = $mysqli->query($sql_venta);

                if ($result_venta->num_rows > 0) {
                    $row_venta = $result_venta->fetch_assoc();

                    echo "<br>";
                    echo "<form>";
                    echo "<h2>Información de la Venta (ID: " . $row_venta["id"] . ")</h2>";
                    echo "<table border='1'>";
                    echo "<tr><th>Fecha</th><th>RUT del Cliente</th><th>Nombre del Cliente</th><th>Dirección Calle</th><th>Dirección Número</th><th>Dirección Comuna</th><th>Dirección Ciudad</th><th>Monto Final</th><th>Descuento</th><th>Teléfonos</th></tr>";
                    echo "<tr>";
                    echo "<td>" . $row_venta["fecha"] . "</td>";
                    echo "<td>" . $row_venta["rut_cliente"] . "</td>";
                    echo "<td>" . $row_venta["nombre_cliente"] . "</td>";
                    echo "<td>" . $row_venta["direccion_calle"] . "</td>"; // Nuevo atributo de clientes
                    echo "<td>" . $row_venta["direccion_numero"] . "</td>"; // Nuevo atributo de clientes
                    echo "<td>" . $row_venta["direccion_comuna"] . "</td>"; // Nuevo atributo de clientes
                    echo "<td>" . $row_venta["direccion_ciudad"] . "</td>"; // Nuevo atributo de clientes
                    echo "<td>$" . $row_venta["monto_final"] . "</td>";
                    echo "<td>" . $row_venta["descuento"] . "%</td>";
                    echo "<td>" . $row_venta["telefonos"] . "</td>"; // Números de teléfono concatenados
                    echo "</tr>";
                    echo "</table>";
                    echo "</form>";

                    // Consulta SQL para obtener los detalles de venta relacionados
                    $sql_detalles_venta = "SELECT * FROM detalles_ventas WHERE id_venta = '$id_venta_mostrar'";
                    $result_detalles_venta = $mysqli->query($sql_detalles_venta);

                    if ($result_detalles_venta->num_rows > 0) {
                        echo "<br>";
                        echo "<br>";
                        echo "<form>";
                        echo "<h2>Detalles de la Venta</h2>";
                        echo "<center><table border='1'>";
                        echo "<tr><th>Nombre del Producto</th><th>Cantidad</th><th>Monto Total</th></tr>";
                        while ($row_detalles_venta = $result_detalles_venta->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_detalles_venta["nombre_producto"] . "</td>";
                            echo "<td>" . $row_detalles_venta["cantidad"] . "</td>";
                            echo "<td>$" . $row_detalles_venta["monto_total"] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table></center>";
                        echo "</form>";
                    } else {
                        echo "<p>No hay detalles de venta para esta venta.</p>";
                    }
                } else {
                    echo "<p>No se encontró una venta con el ID seleccionado.</p>";
                }
            }

            $mysqli->close();
        } else {
            echo "<p>Por favor, selecciona un ID de venta o utiliza el botón para mostrar todas las ventas.</p>";
        }
        ?>


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const detalleVentaTable = document.getElementById("detalle_venta_table");
            const tbody = detalleVentaTable.getElementsByTagName("tbody")[0];
            const agregarProductoBtn = document.getElementById("agregar_producto_btn");
            const montoFinalInput = document.getElementById("monto_final");
            const descuentoInput = document.getElementById("descuento");

            // Función para calcular el monto total de una fila
            function calcularMontoTotal(fila) {
                const cantidadInput = fila.querySelector(".cantidad");
                const precioActualInput = fila.querySelector(".precio_actual");
                const montoTotalInput = fila.querySelector(".monto_total");

                const cantidad = parseFloat(cantidadInput.value);
                const precioActual = parseFloat(precioActualInput.value);
                const montoTotal = isNaN(cantidad) || isNaN(precioActual) ? 0 : cantidad * precioActual;
                montoTotalInput.value = montoTotal.toFixed(2);

                // Recalcular el monto final
                recalcularMontoFinal();
            }

            agregarProductoBtn.addEventListener("click", function () {
                // Crear una nueva fila de producto
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>
                        <select name="nombre_producto[]" class="nombre_producto" required>
                            <option value="">Seleccionar Producto</option>
                            <?php
                            // Repetimos la misma consulta aquí para mantener las opciones actualizadas
                            // Conexión a la base de datos
                            $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

                            // Verificar la conexión
                            if ($mysqli->connect_error) {
                                die("Error de conexión: " . $mysqli->connect_error);
                            }

                            // Consulta para obtener los nombres de los productos
                            $sql_productos = "SELECT nombre, precio_actual FROM productos";
                            $result_productos = $mysqli->query($sql_productos);

                            if ($result_productos->num_rows > 0) {
                                while ($row = $result_productos->fetch_assoc()) {
                                    echo '<option value="' . $row['nombre'] . '" data-precio="' . $row['precio_actual'] . '">' . $row['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="cantidad[]" class="cantidad" required></td>
                    <td><input type="text" name="precio_actual[]" class="precio_actual" readonly></td>
                    <td><input type="text" name="monto_total[]" class="monto_total" readonly></td>
                    <td><button type="button" class="eliminar_producto_btn">Eliminar</button></td>
                `;

                // Agregar la nueva fila a la tabla
                tbody.appendChild(newRow);

                // Agregar evento para eliminar fila
                const eliminarProductoBtns = newRow.getElementsByClassName("eliminar_producto_btn");
                for (const eliminarBtn of eliminarProductoBtns) {
                    eliminarBtn.addEventListener("click", function () {
                        tbody.removeChild(newRow);
                        recalcularMontoFinal(); // Recalcular al eliminar la fila
                    });
                }

                // Agregar evento para cargar el precio actual y calcular el monto total en tiempo real
                const nombreProductoSelect = newRow.querySelector(".nombre_producto");
                const cantidadInput = newRow.querySelector(".cantidad");
                const precioActualInput = newRow.querySelector(".precio_actual");
                const montoTotalInput = newRow.querySelector(".monto_total");

                nombreProductoSelect.addEventListener("change", function () {
                    const selectedOption = nombreProductoSelect.options[nombreProductoSelect.selectedIndex];
                    const precioActual = parseFloat(selectedOption.getAttribute("data-precio"));
                    precioActualInput.value = isNaN(precioActual) ? "" : precioActual.toFixed(2);
                    calcularMontoTotal(newRow);
                });

                cantidadInput.addEventListener("input", function () {
                    calcularMontoTotal(newRow);
                });
            });

            // Función para recalcular el monto final en el formulario principal
            function recalcularMontoFinal() {
                const filas = tbody.getElementsByTagName("tr");
                let montoTotal = 0;

                for (const fila of filas) {
                    const montoTotalInput = fila.querySelector(".monto_total");
                    const monto = parseFloat(montoTotalInput.value);
                    if (!isNaN(monto)) {
                        montoTotal += monto;
                    }
                }

                // Aplicar el descuento si es un número válido
                const descuento = parseFloat(descuentoInput.value);
                if (!isNaN(descuento) && descuento >= 0) {
                    montoTotal -= (montoTotal * (descuento / 100));
                }

                montoFinalInput.value = montoTotal.toFixed(2);
            }

            // Agregar evento para calcular el monto final en el formulario principal al cambiar el descuento
            descuentoInput.addEventListener("input", recalcularMontoFinal);

            // Formulario de modificar venta
            const detalleVentaTableModificar = document.getElementById("detalle_venta_table_modificar");
            const tbodyModificar = detalleVentaTableModificar.getElementsByTagName("tbody")[0];
            const agregarProductoBtnModificar = document.getElementById("agregar_producto_btn_modificar");
            const nuevoMontoFinalInput = document.getElementById("nuevo_monto_final");
            const nuevoDescuentoInput = document.getElementById("nuevo_descuento");

            // Función para calcular el monto total en el formulario de modificar
            function calcularMontoTotalModificado(fila) {
                const cantidadInput = fila.querySelector(".cantidad_modificar");
                const precioActualInput = fila.querySelector(".precio_actual_modificar");
                const montoTotalInput = fila.querySelector(".monto_total_modificar");

                const cantidad = parseFloat(cantidadInput.value);
                const precioActual = parseFloat(precioActualInput.value);
                const montoTotal = isNaN(cantidad) || isNaN(precioActual) ? 0 : cantidad * precioActual;
                montoTotalInput.value = montoTotal.toFixed(2);

                // Recalcular el monto final
                recalcularNuevoMontoFinal();
            }

            agregarProductoBtnModificar.addEventListener("click", function () {
                // Crear una nueva fila de producto en el formulario de modificar
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>
                        <select name="nuevo_nombre_producto[]" class="nombre_producto_modificar" required>
                            <option value="">Seleccionar Producto</option>
                            <?php
                            // Repetimos la misma consulta aquí para mantener las opciones actualizadas
                            // Conexión a la base de datos
                            $mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

                            // Verificar la conexión
                            if ($mysqli->connect_error) {
                                die("Error de conexión: " . $mysqli->connect_error);
                            }

                            // Consulta para obtener los nombres de los productos
                            $sql_productos = "SELECT nombre, precio_actual FROM productos";
                            $result_productos = $mysqli->query($sql_productos);

                            if ($result_productos->num_rows > 0) {
                                while ($row = $result_productos->fetch_assoc()) {
                                    echo '<option value="' . $row['nombre'] . '" data-precio="' . $row['precio_actual'] . '">' . $row['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="nuevo_cantidad[]" class="cantidad_modificar" required></td>
                    <td><input type="text" name="nuevo_precio_actual[]" class="precio_actual_modificar" readonly></td>
                    <td><input type="text" name="nuevo_monto_total[]" class="monto_total_modificar" readonly></td>
                    <td><button type="button" class="eliminar_producto_btn_modificar">Eliminar</button></td>
                `;

                // Agregar la nueva fila a la tabla de modificar
                tbodyModificar.appendChild(newRow);

                // Agregar evento para eliminar fila
                const eliminarProductoBtns = newRow.getElementsByClassName("eliminar_producto_btn_modificar");
                for (const eliminarBtn of eliminarProductoBtns) {
                    eliminarBtn.addEventListener("click", function () {
                        tbodyModificar.removeChild(newRow);
                        recalcularNuevoMontoFinal(); // Recalcular al eliminar la fila
                    });
                }

                // Agregar evento para cargar el precio actual y calcular el monto total en tiempo real en el formulario de modificar
                const nombreProductoSelect = newRow.querySelector(".nombre_producto_modificar");
                const cantidadInput = newRow.querySelector(".cantidad_modificar");
                const precioActualInput = newRow.querySelector(".precio_actual_modificar");
                const montoTotalInput = newRow.querySelector(".monto_total_modificar");

                nombreProductoSelect.addEventListener("change", function () {
                    const selectedOption = nombreProductoSelect.options[nombreProductoSelect.selectedIndex];
                    const precioActual = parseFloat(selectedOption.getAttribute("data-precio"));
                    precioActualInput.value = isNaN(precioActual) ? "" : precioActual.toFixed(2);
                    calcularMontoTotalModificado(newRow);
                });

                cantidadInput.addEventListener("input", function () {
                    calcularMontoTotalModificado(newRow);
                });
            });

            // Función para recalcular el monto final en el formulario de modificar
            function recalcularNuevoMontoFinal() {
                const filas = tbodyModificar.getElementsByTagName("tr");
                let montoTotal = 0;

                for (const fila of filas) {
                    const montoTotalInput = fila.querySelector(".monto_total_modificar");
                    const monto = parseFloat(montoTotalInput.value);
                    if (!isNaN(monto)) {
                        montoTotal += monto;
                    }
                }

                // Aplicar el descuento si es un número válido en el formulario de modificar
                const descuento = parseFloat(nuevoDescuentoInput.value);
                if (!isNaN(descuento) && descuento >= 0) {
                    montoTotal -= (montoTotal * (descuento / 100));
                }

                nuevoMontoFinalInput.value = montoTotal.toFixed(2);
            }

            // Agregar evento para calcular el monto final en el formulario de modificar al cambiar el descuento
            nuevoDescuentoInput.addEventListener("input", recalcularNuevoMontoFinal);
        });
    </script>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>
</body>

</html>