<?php
// Establecer la conexión con la base de datos
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

if (isset($_POST['agregar_venta'])) {
    // Obtener los datos del formulario de venta
    $id_venta = $_POST['id_venta'];
    $fecha = $_POST['fecha'];
    $rut_cliente = $_POST['rut_cliente'];
    $monto_final = $_POST['monto_final'];
    $descuento = $_POST['descuento'];

    // Insertar los datos de la venta en la tabla 'venta'
    $sql_venta = "INSERT INTO venta (id, fecha, rut_cliente, monto_final, descuento) VALUES ('$id_venta', '$fecha', '$rut_cliente', '$monto_final', '$descuento')";

    if ($mysqli->query($sql_venta) === TRUE) {
        $mensaje_venta = "Venta registrada correctamente.";
    } else {
        $mensaje_venta = "Error al registrar la venta: " . $mysqli->error;
    }

    // Obtener los datos del formulario de detalle de venta (que son arreglos)
    $id_productos = $_POST['nombre_producto'];
    $cantidades = $_POST['cantidad'];
    $montos_totales = $_POST['monto_total'];

    // Insertar los datos del detalle de venta en la tabla 'detalles_ventas'
    for ($i = 0; $i < count($id_productos); $i++) {
        $id_producto = $id_productos[$i];
        $cantidad = $cantidades[$i];
        $monto_total = $montos_totales[$i];

        $sql_detalle_venta = "INSERT INTO detalles_ventas (id_venta, nombre_producto, cantidad, monto_total) VALUES ('$id_venta', '$id_producto', '$cantidad', '$monto_total')";

        if ($mysqli->query($sql_detalle_venta) !== TRUE) {
            echo "Error al agregar detalle de venta: " . $mysqli->error;
            // Puedes agregar aquí un código para manejar errores si lo deseas.
        }
    }

} elseif (isset($_POST['modificar_venta'])) {
    // Obtener los datos del formulario de modificar venta
    $id_venta_modificar = $_POST['id_venta_modificar'];
    $nueva_fecha = $_POST['nueva_fecha'];
    $nuevo_rut_cliente = $_POST['nuevo_rut_cliente'];
    $nuevo_monto_final = $_POST['nuevo_monto_final'];
    $nuevo_descuento = $_POST['nuevo_descuento'];

    // Actualizar los datos de la venta en la tabla 'venta'
    $sql_modificar_venta = "UPDATE venta SET fecha = '$nueva_fecha', rut_cliente = '$nuevo_rut_cliente', monto_final = '$nuevo_monto_final', descuento = '$nuevo_descuento' WHERE id = '$id_venta_modificar'";

    if ($mysqli->query($sql_modificar_venta) === TRUE) {
        $mensaje_modificar = "Venta modificada correctamente.";
    } else {
        $mensaje_modificar = "Error al modificar la venta: " . $mysqli->error;
    }

    // Obtener los datos del formulario de detalle de venta modificado (que son arreglos)
    $id_productos_modificar = $_POST['nuevo_nombre_producto'];
    $cantidades_modificar = $_POST['nuevo_cantidad'];
    $montos_totales_modificar = $_POST['nuevo_monto_total'];

    // Eliminar los registros de detalle de venta existentes para esta venta
    $sql_eliminar_detalle_venta = "DELETE FROM detalles_ventas WHERE id_venta = '$id_venta_modificar'";

    if ($mysqli->query($sql_eliminar_detalle_venta) !== TRUE) {
        echo "Error al eliminar detalles de venta: " . $mysqli->error;
        // Puedes agregar aquí un código para manejar errores si lo deseas.
    }

    // Insertar los datos del detalle de venta modificado en la tabla 'detalles_ventas'
    for ($i = 0; $i < count($id_productos_modificar); $i++) {
        $id_producto_modificar = $id_productos_modificar[$i];
        $cantidad_modificar = $cantidades_modificar[$i];
        $monto_total_modificar = $montos_totales_modificar[$i];

        $sql_detalle_venta_modificar = "INSERT INTO detalles_ventas (id_venta, nombre_producto, cantidad, monto_total) VALUES ('$id_venta_modificar', '$id_producto_modificar', '$cantidad_modificar', '$monto_total_modificar')";

        if ($mysqli->query($sql_detalle_venta_modificar) !== TRUE) {
            echo "Error al agregar detalle de venta modificado: " . $mysqli->error;
            // Puedes agregar aquí un código para manejar errores si lo deseas.
        }
    }
}
if (isset($_POST['eliminar_venta'])) {
    // Obtener el ID de venta a eliminar
    $id_venta_eliminar = $_POST['eliminar_id_venta'];

    // Eliminar los detalles de venta correspondientes primero
    $sql_eliminar_detalles_venta = "DELETE FROM detalles_ventas WHERE id_venta = '$id_venta_eliminar'";
    
    if ($mysqli->query($sql_eliminar_detalles_venta) === TRUE) {
        // Luego, eliminar la venta de la tabla 'venta'
        $sql_eliminar_venta = "DELETE FROM venta WHERE id = '$id_venta_eliminar'";
        
        if ($mysqli->query($sql_eliminar_venta) === TRUE) {
            $mensaje_eliminar = "Venta y detalles de venta eliminados correctamente.";
        } else {
            $mensaje_eliminar = "Error al eliminar la venta: " . $mysqli->error;
        }
    } else {
        $mensaje_eliminar = "Error al eliminar detalles de venta: " . $mysqli->error;
    }
}

// Cerrar la conexión
$mysqli->close();
header("Location: venta.php?mensaje_venta=$mensaje_venta&mensaje_modificar=$mensaje_modificar&mensaje_eliminar=$mensaje_eliminar");
?>
