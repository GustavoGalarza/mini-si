<?php
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mensaje_agregar = "";
$error_agregar = "";
$mensaje_modificar = "";
$error_modificar = "";
$mensaje_eliminar = "";
$error_eliminar = "";

// Agregar Proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_proveedor"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_proveedor"])) {
        $rut = $_POST["rut"];
        $nombre = $_POST["nombre"];
        $direccion_calle = $_POST["direccion_calle"];
        $direccion_numero = $_POST["direccion_numero"];
        $direccion_comuna = $_POST["direccion_comuna"];
        $direccion_ciudad = $_POST["direccion_ciudad"];
        $telefono = $_POST["telefono"];
        $pagina_web = $_POST["pagina_web"];
    
        $sql = "INSERT INTO proveedores (rut, nombre, direccion_calle, direccion_numero, direccion_comuna, direccion_ciudad, telefono, pagina_web) 
                VALUES ('$rut', '$nombre', '$direccion_calle', '$direccion_numero', '$direccion_comuna', '$direccion_ciudad', '$telefono', '$pagina_web')";
    
        if ($mysqli->query($sql) === TRUE) {
            $mensaje_agregar = "Proveedor agregado exitosamente.";
        } else {
            $error_agregar = "Error al agregar proveedor: " . $mysqli->error;
        }
    }
}

// Modificar Proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modificar_proveedor"])) {
    $rut_modificar = $_POST["rut_modificar"];
    $nuevo_nombre = $_POST["nuevo_nombre"];
    $nuevo_direccion_calle = $_POST["nuevo_direccion_calle"];
    $nuevo_direccion_numero = $_POST["nuevo_direccion_numero"];
    $nuevo_direccion_comuna = $_POST["nuevo_direccion_comuna"];
    $nuevo_direccion_ciudad = $_POST["nuevo_direccion_ciudad"];
    $nuevo_telefono = $_POST["nuevo_telefono"];
    $nuevo_pagina_web = $_POST["nuevo_pagina_web"];

    $sql = "UPDATE proveedores SET nombre='$nuevo_nombre', direccion_calle='$nuevo_direccion_calle', direccion_numero='$nuevo_direccion_numero', direccion_comuna='$nuevo_direccion_comuna', direccion_ciudad='$nuevo_direccion_ciudad', telefono='$nuevo_telefono', pagina_web='$nuevo_pagina_web' WHERE rut='$rut_modificar'";

    if ($mysqli->query($sql) === TRUE) {
        $mensaje_modificar = "Proveedor modificado exitosamente.";
    } else {
        $error_modificar = "Error al modificar proveedor: " . $mysqli->error;
    }
}

// Eliminar Proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_proveedor"])) {
    $rut_eliminar = $_POST["rut_eliminar"];

    $sql = "DELETE FROM proveedores WHERE rut='$rut_eliminar'";

    if ($mysqli->query($sql) === TRUE) {
        $mensaje_eliminar = "Proveedor eliminado exitosamente.";
    } else {
        $error_eliminar = "Error al eliminar proveedor: " . $mysqli->error;
    }
}


?>