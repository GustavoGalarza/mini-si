<?php
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mensaje_agregar_venta = "";
$error_agregar_venta = "";
$mensaje_agregar_detalles_venta = "";
$error_agregar_detalles_venta = "";

// Agregar Venta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"])) {
    $accion = $_POST["accion"];

    if ($accion === "agregar_venta") {
        // Agregar Venta
        $id_venta = $_POST["id_venta"];
        $fecha = $_POST["fecha"];
        $rut_cliente = $_POST["rut_cliente"];

        // existe en la base de datos
        $verificar_cliente_query = "SELECT * FROM clientes WHERE rut='$rut_cliente'";
        $resultado_verificar_cliente = $mysqli->query($verificar_cliente_query);

        if ($resultado_verificar_cliente->num_rows === 0) {
            $error_agregar_venta = "El RUT del cliente no existe en la base de datos.";
        } else {
            $sql = "INSERT INTO ventas (id, fecha, rut_cliente) VALUES ($id_venta, '$fecha', '$rut_cliente')";

            if ($mysqli->query($sql) === TRUE) {
                $mensaje_agregar_venta = "Venta agregada exitosamente.";
            } else {
                $error_agregar_venta = "Error al agregar venta: " . $mysqli->error;
            }
        }
    } elseif ($accion === "agregar_detalles_venta") {
        // Agregar Detalles de Venta
        $id_venta = $_POST["id_venta"];
        $id_productos = $_POST["id_producto"]; // Array de IDs de productos
        $precios_venta = $_POST["precio_venta"]; // Array de precios de venta
        $cantidades = $_POST["cantidad"]; // Array de cantidades
        $montos_totales = $_POST["monto_total"]; // Array de montos totales

        // Iterar sobre los arrays para insertar cada detalle de venta
        for ($i = 0; $i < count($id_productos); $i++) {
            $id_producto = $id_productos[$i];
            $precio_venta = $precios_venta[$i];
            $cantidad = $cantidades[$i];
            $monto_total = $montos_totales[$i];

            $sql = "INSERT INTO detalles_ventas (id_venta, id_producto, precio_venta, cantidad, monto_total) VALUES ($id_venta, $id_producto, $precio_venta, $cantidad, $monto_total)";

            if ($mysqli->query($sql) !== TRUE) {
                $error_agregar_detalles_venta = "Error al agregar detalles de venta: " . $mysqli->error;
                break; // En caso de error, salir del bucle
            }
        }

        if (!isset($error_agregar_detalles_venta)) {
            $mensaje_agregar_detalles_venta = "Detalles de venta agregados exitosamente.";
        }
    }
}

$mysqli->close();
?>
