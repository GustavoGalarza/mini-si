<!DOCTYPE html>
<html>

<head>
    <title>Gestionar Ventas</title>
</head>

<body>
    <h1>Gestionar Ventas</h1>

    <!-- Agregar Venta -->
    <h2>Agregar Venta</h2>
    <?php
    $mensaje_agregar_venta = "";
    $error_agregar_venta = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_venta"])) {
        include 'ventas_BD.php'; // Incluye el archivo con la lógica de BD para ventas

        if (!empty($mensaje_agregar_venta)) {
            echo "<p id='mensaje_venta'>$mensaje_agregar_venta</p>"; // Agregamos un ID aquí
        } elseif (!empty($error_agregar_venta)) {
            echo "<p style='color: red;' id='mensaje_venta'>$error_agregar_venta</p>"; // Agregamos un ID aquí
        }
    }
    ?>
    <form id="formulario_venta" method="post">
        <input type="hidden" name="accion" value="agregar_venta">
        <label>ID de Venta:</label>
        <input type="text" name="id_venta" required>
        <br>
        <label>Fecha:</label>
        <input type="date" name="fecha" required>
        <br>
        <label>RUT del Cliente:</label>
        <input type="text" name="rut_cliente" required>
        <br>
        <input type="submit" name="agregar_venta" value="Agregar Venta">
    </form>

    <!-- Agregar Detalles de Venta -->
    <h2>Agregar Detalles de Venta</h2>
    <?php
    $mensaje_agregar_detalles_venta = "";
    $error_agregar_detalles_venta = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_detalles_venta"])) {
        include 'ventas_BD.php'; // Incluye el archivo con la lógica de BD para ventas

        if (!empty($mensaje_agregar_detalles_venta)) {
            echo "<p id='mensaje_detalles_venta'>$mensaje_agregar_detalles_venta</p>"; // Agregamos un ID aquí
        } elseif (!empty($error_agregar_detalles_venta)) {
            echo "<p style='color: red;' id='mensaje_detalles_venta'>$error_agregar_detalles_venta</p>"; // Agregamos un ID aquí
        }
    }
    ?>
    <form id="formulario_detalles_venta" method="post">

        <input type="hidden" name="accion" value="agregar_detalles_venta">

        <label>ID de Venta:</label>
        <input type="text" name="id_venta" required>
        <br>

        <!-- Agregar campo para ingresar la cantidad de productos -->
        <label>Cantidad de Productos:</label>
        <input type="number" name="cantidad_productos" required>
        <br>

        <!-- Contenedor para agregar productos dinámicamente -->
        <div id="productos-container"></div>

        <br>
        <input type="submit" name="agregar_detalles_venta" value="Agregar Detalles de Venta">
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            var formVenta = document.querySelector("#formulario_venta");
            var formDetallesVenta = document.querySelector("#formulario_detalles_venta");
            var productosContainer = document.querySelector("#productos-container");

            formVenta.addEventListener("submit", function (e) {
                e.preventDefault();
                var formData = new FormData(formVenta);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "ventas_BD.php", true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById("mensaje_venta").innerHTML = xhr.responseText;
                    } else {
                        console.error("Error en la petición AJAX");
                    }
                };
                xhr.send(formData);
                formVenta.reset();
            });

            formDetallesVenta.addEventListener("submit", function (e) {
                e.preventDefault();
                var formData = new FormData(formDetallesVenta);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "ventas_BD.php", true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById("mensaje_detalles_venta").innerHTML = xhr.responseText;
                    } else {
                        console.error("Error en la petición AJAX");
                    }
                };
                xhr.send(formData);
                formDetallesVenta.reset();
            });

            // Agregar campos de productos dinámicamente
            formDetallesVenta.elements["cantidad_productos"].addEventListener("input", function () {
                var cantidadProductos = parseInt(formDetallesVenta.elements["cantidad_productos"].value) || 0;
                productosContainer.innerHTML = ""; // Limpiar los campos existentes

                for (var i = 0; i < cantidadProductos; i++) {
                    var productoDiv = document.createElement("div");
                    productoDiv.innerHTML = `
                        <hr>
                        <label>ID de Producto:</label>
                        <input type="text" name="id_producto[]" required>
                        <br>
                        <label>Precio de Venta:</label>
                        <input type="text" name="precio_venta[]" required>
                        <br>
                        <label>Cantidad:</label>
                        <input type="text" name="cantidad[]" required>
                        <br>
                        <label>Monto Total:</label>
                        <input type="text" name="monto_total[]" required>
                        <br>
                    `;
                    productosContainer.appendChild(productoDiv);
                }
            });
        });
    </script>
</body>

</html>