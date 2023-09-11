<?php
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$direccion_calle = $_POST['direccion_calle'];
$direccion_numero = $_POST['direccion_numero'];
$direccion_comuna = $_POST['direccion_comuna'];
$direccion_ciudad = $_POST['direccion_ciudad'];

$query = "INSERT INTO clientes (rut, nombre, direccion_calle, direccion_numero, direccion_comuna, direccion_ciudad) 
          VALUES ('$rut', '$nombre', '$direccion_calle', '$direccion_numero', '$direccion_comuna', '$direccion_ciudad')";

if ($mysqli->query($query) === TRUE) {
    echo "Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
} else {
    echo "Error al registrar el cliente: " . $mysqli->error;
}

$mysqli->close();
?>