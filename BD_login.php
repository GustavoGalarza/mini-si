<?php
$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];

$query = "SELECT * FROM clientes WHERE rut='$rut' AND nombre='$nombre'";
$result = $mysqli->query($query);

if ($result->num_rows == 1) {
    header("Location: interfaz.php");
    
    exit();
} else {
    echo "Inicio de sesión fallido. RUT o nombre incorrectos.";
}

$mysqli->close();
?>