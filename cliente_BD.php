<?php
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

$mensaje = "";
$error = "";
$mensaje_eliminar = ""; 
$error_eliminar = "";   
$mensaje_modificar = ""; 
$error_modificar = "";   

//agregar clientes//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_cliente'])) {
    $rut = mysqli_real_escape_string($mysqli_link, $_POST['rut']);
    $nombre = mysqli_real_escape_string($mysqli_link, $_POST['nombre']);
    $calle = mysqli_real_escape_string($mysqli_link, $_POST['calle']);
    $numero = mysqli_real_escape_string($mysqli_link, $_POST['numero']);
    $comuna = mysqli_real_escape_string($mysqli_link, $_POST['comuna']);
    $ciudad = mysqli_real_escape_string($mysqli_link, $_POST['ciudad']);

    $insert_query = "INSERT INTO clientes (rut, nombre, direccion_calle, direccion_numero, direccion_comuna, direccion_ciudad) 
                     VALUES ('$rut', '$nombre', '$calle', '$numero', '$comuna', '$ciudad')";

    if (mysqli_query($mysqli_link, $insert_query)) {
        $mensaje = "Cliente agregado exitosamente.";

        if (!empty($_POST['telefonos'])) {
            $telefonos = explode(",", $_POST['telefonos']);
            foreach ($telefonos as $telefono) {
                $telefono = trim($telefono);
                $insert_tel_query = "INSERT INTO telefonos_clientes (rut_cliente, telefono) 
                                    VALUES ('$rut', '$telefono')";
                mysqli_query($mysqli_link, $insert_tel_query);
            }
        }
    } else {
        $error = "Error al agregar el cliente: " . mysqli_error($mysqli_link);
    }
}
//modificar//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_cliente'])) {
    $rut_modificar = mysqli_real_escape_string($mysqli_link, $_POST['rut_modificar']);
    $nuevo_nombre = mysqli_real_escape_string($mysqli_link, $_POST['nuevo_nombre']);
    $nueva_calle = mysqli_real_escape_string($mysqli_link, $_POST['nueva_calle']);
    $nuevo_numero = mysqli_real_escape_string($mysqli_link, $_POST['nuevo_numero']);
    $nueva_comuna = mysqli_real_escape_string($mysqli_link, $_POST['nueva_comuna']);
    $nueva_ciudad = mysqli_real_escape_string($mysqli_link, $_POST['nueva_ciudad']);

    // Eliminar los teléfonos existentes del cliente
    $delete_tel_query = "DELETE FROM telefonos_clientes WHERE rut_cliente = '$rut_modificar'";
    mysqli_query($mysqli_link, $delete_tel_query);

    // Actualizar cliente
    $update_query = "UPDATE clientes SET nombre = '$nuevo_nombre', direccion_calle = '$nueva_calle', direccion_numero = '$nuevo_numero', direccion_comuna = '$nueva_comuna', direccion_ciudad = '$nueva_ciudad' WHERE rut = '$rut_modificar'";
    if (mysqli_query($mysqli_link, $update_query)) {
        $mensaje_modificar = "Cliente modificado exitosamente.";

        if (!empty($_POST['nuevos_telefonos'])) {
            $nuevos_telefonos = explode(",", $_POST['nuevos_telefonos']);
            foreach ($nuevos_telefonos as $telefono) {
                $telefono = trim($telefono);
                $insert_tel_query = "INSERT INTO telefonos_clientes (rut_cliente, telefono) 
                                    VALUES ('$rut_modificar', '$telefono')";
                mysqli_query($mysqli_link, $insert_tel_query);
            }
        }
    } else {
        $error_modificar = "Error al modificar el cliente: " . mysqli_error($mysqli_link);
    }


}

 //eliminar//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_cliente'])) {
    $rut_eliminar = mysqli_real_escape_string($mysqli_link, $_POST['rut_eliminar']);

    // Eliminar los teléfonos 
    $delete_tel_query = "DELETE FROM telefonos_clientes WHERE rut_cliente = '$rut_eliminar'";
    mysqli_query($mysqli_link, $delete_tel_query);

    // Eliminar el cliente
    $delete_cliente_query = "DELETE FROM clientes WHERE rut = '$rut_eliminar'";
    if (mysqli_query($mysqli_link, $delete_cliente_query)) {
        $mensaje_eliminar = "Cliente eliminado exitosamente.";
    } else {
        $error_eliminar = "Error al eliminar el cliente: " . mysqli_error($mysqli_link);
    }
}


//mostrar//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mostrar_clientes'])) {
    $clientes_query = "SELECT * FROM clientes";
    $clientes = array();
    $result_clientes = mysqli_query($mysqli_link, $clientes_query);
    while ($cliente_row = mysqli_fetch_assoc($result_clientes)) {
        $rut_cliente = $cliente_row['rut'];
        $telefonos_query = "SELECT telefono FROM telefonos_clientes WHERE rut_cliente = '$rut_cliente'";
        $result_telefonos = mysqli_query($mysqli_link, $telefonos_query);
        $telefonos = array();
        while ($telefono_row = mysqli_fetch_assoc($result_telefonos)) {
            $telefonos[] = $telefono_row['telefono'];
        }
        $cliente_row['telefonos'] = $telefonos;
        $clientes[] = $cliente_row;
    }
}


    mysqli_close($mysqli_link); // Cerrar la conexión al final de la página
