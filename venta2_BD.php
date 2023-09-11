<?php
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario de venta2
    if (isset($_POST["id_venta"]) && isset($_POST["fecha"]) && isset($_POST["rut_cliente"])) {
        $id_venta = $_POST["id_venta"];
        $fecha = $_POST["fecha"];
        $rut_cliente = $_POST["rut_cliente"];
        
        // Consulta SQL para insertar en venta2
        $sql_venta = "INSERT INTO venta2 (id, fecha, rut_cliente, monto_final) VALUES ('$id_venta', '$fecha', '$rut_cliente', 0) ON DUPLICATE KEY UPDATE fecha = VALUES(fecha), rut_cliente = VALUES(rut_cliente)";
        
        if ($mysqli->query($sql_venta) === TRUE) {
            $mensaje_venta = "Venta registrada correctamente.";
        } else {
            $mensaje_venta = "Error al registrar la venta: " . $mysqli->error;
        }
    }

    // Procesar el formulario de detalles_venta2
    if (isset($_POST["nombre_producto"]) && isset($_POST["cantidad"]) && isset($_POST["monto"])) {
        $nombre_producto = $_POST["nombre_producto"];
        $cantidades = $_POST["cantidad"];
        $montos = $_POST["monto"];
        $id_venta = $_POST["id_venta"];

        // Eliminar los detalles de venta existentes con el mismo ID de venta
        $sql_eliminar_detalles = "DELETE FROM detalles_venta2 WHERE id_venta = '$id_venta'";
        if ($mysqli->query($sql_eliminar_detalles) !== TRUE) {
            $mensaje_detalles_venta = "Error al eliminar los detalles de venta anteriores: " . $mysqli->error;
        }

        // Insertar detalles de venta y actualizar el stock de productos
        for ($i = 0; $i < count($nombre_producto); $i++) {
            $nombre = $nombre_producto[$i];
            $cantidad = $cantidades[$i];
            $monto = $montos[$i];

            // Consulta SQL para insertar en detalles_venta2
            $sql_detalles_venta = "INSERT INTO detalles_venta2 (id_venta, nombre_producto, cantidad, monto_total) VALUES ('$id_venta', '$nombre', '$cantidad', '$monto')";

            if ($mysqli->query($sql_detalles_venta) !== TRUE) {
                $mensaje_detalles_venta = "Error al registrar los detalles de venta: " . $mysqli->error;
                break; // En caso de error, detener el bucle
            }

            // Consulta SQL para actualizar el stock en productos
            $sql_actualizar_stock = "UPDATE productos SET stock = stock - '$cantidad' WHERE nombre = '$nombre'";
            if ($mysqli->query($sql_actualizar_stock) !== TRUE) {
                $mensaje_detalles_venta = "Error al actualizar el stock en la tabla productos: " . $mysqli->error;
                break; // En caso de error, detener el bucle
            }
        }

        if (!isset($mensaje_detalles_venta)) {
            $mensaje_detalles_venta = "Detalles de venta registrados correctamente.";
        }
    }
    // Procesar el formulario de actualización de monto final de venta2
    if (isset($_POST["id_venta_actualizar"])) {
        $id_venta_actualizar = $_POST["id_venta_actualizar"];

        // Consulta SQL para obtener el monto total de los detalles de venta con el mismo ID de venta
        $sql_monto_total_detalles = "SELECT SUM(monto_total) AS total FROM detalles_venta2 WHERE id_venta = '$id_venta_actualizar'";
        $result = $mysqli->query($sql_monto_total_detalles);

        if ($result && $row = $result->fetch_assoc()) {
            $monto_total_detalles = $row["total"];

            // Consulta SQL para actualizar el monto final en venta2
            $sql_actualizar_monto_final = "UPDATE venta2 SET monto_final = '$monto_total_detalles' WHERE id = '$id_venta_actualizar'";
            
            if ($mysqli->query($sql_actualizar_monto_final) === TRUE) {
                $mensaje_actualizacion = "Actualizado correctamente.";
            } else {
                $mensaje_actualizacion = "Error al actualizar el monto final de Venta: " . $mysqli->error;
            }
        } else {
            $mensaje_actualizacion = "No se encontraron detalles de venta para el ID de Venta proporcionado.";
        }
    }
    
    // Procesar el formulario de modificación de registro de ventas
    if (isset($_POST["id_venta_modificar"]) && isset($_POST["nueva_fecha"]) && isset($_POST["nuevo_rut_cliente"])) {
        $id_venta_modificar = $_POST["id_venta_modificar"];
        $nueva_fecha = $_POST["nueva_fecha"];
        $nuevo_rut_cliente = $_POST["nuevo_rut_cliente"];

        // Consulta SQL para actualizar el registro de ventas
        $sql_modificar_venta = "UPDATE venta2 SET fecha = '$nueva_fecha', rut_cliente = '$nuevo_rut_cliente' WHERE id = '$id_venta_modificar'";
        
        if ($mysqli->query($sql_modificar_venta) === TRUE) {
            $mensaje_modificacion = "Registro de ventas modificado correctamente.";
        } else {
            $mensaje_modificacion = "Error al modificar el registro de ventas: " . $mysqli->error;
        }
    }

    if (isset($_POST["id_venta_eliminar"])) {
        $id_venta_eliminar = $_POST["id_venta_eliminar"];

        // Consulta SQL para eliminar todos los detalles relacionados con el mismo ID de venta
        $sql_eliminar_detalles = "DELETE FROM detalles_venta2 WHERE id_venta = '$id_venta_eliminar'";
        
        if ($mysqli->query($sql_eliminar_detalles) === TRUE) {
            // Luego de eliminar los detalles, eliminamos el registro de ventas
            $sql_eliminar_venta = "DELETE FROM venta2 WHERE id = '$id_venta_eliminar'";
            
            if ($mysqli->query($sql_eliminar_venta) === TRUE) {
                $mensaje_eliminacion = "Registro de ventas y detalles eliminados correctamente.";
            } else {
                $mensaje_eliminacion = "Error al eliminar el registro de ventas: " . $mysqli->error;
            }
        } else {
            $mensaje_eliminacion = "Error al eliminar los detalles de venta: " . $mysqli->error;
        }
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();

    // Redirigir a venta2.php con mensajes de confirmación
    header("Location: venta2.php?mensaje_venta=$mensaje_venta&mensaje_detalles_venta=$mensaje_detalles_venta&mensaje_actualizacion=$mensaje_actualizacion&mensaje_modificacion=$mensaje_modificacion&mensaje_eliminacion=$mensaje_eliminacion");
}
?>