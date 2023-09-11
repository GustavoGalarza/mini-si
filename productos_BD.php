<?php
$mysqli_link = mysqli_connect("localhost", "root", "", "gestion_ventas");
if (mysqli_connect_errno()) {
    printf("MySQL connection failed with the error: %s", mysqli_connect_error());
    exit;
}

$mensaje_agregar = "";
$error_agregar = "";
$mensaje_modificar = "";
$error_modificar = "";
$mensaje_eliminar = "";
$error_eliminar = "";

// Agregar Producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_producto'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria_agregar'];
    $proveedor = $_POST['proveedor'];

    $insert_query = "INSERT INTO productos (nombre, precio_actual, stock, id_categoria, rut_proveedor) 
                     VALUES ('$nombre', $precio, $stock, $categoria, '$proveedor')";

    if (mysqli_query($mysqli_link, $insert_query)) {
        $mensaje_agregar = "Producto agregado exitosamente.";
    } else {
        $error_agregar = "Error al agregar el producto: " . mysqli_error($mysqli_link);
    }
}

// Modificar Producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_producto'])) {
    $nombre = $_POST['nombre_modificar'];
    $nuevoNombre = $_POST['nuevo_nombre'];
    $nuevoPrecio = $_POST['nuevo_precio'];
    $nuevoStock = $_POST['nuevo_stock'];
    $nuevaCategoria = $_POST['nueva_categoria_modificar'];
    $nuevoProveedor = $_POST['nuevo_proveedor'];

    $update_query = "UPDATE productos 
                     SET nombre = '$nuevoNombre', precio_actual = $nuevoPrecio, 
                     stock = $nuevoStock, id_categoria = $nuevaCategoria, rut_proveedor = '$nuevoProveedor' 
                     WHERE nombre = '$nombre'";

    if (mysqli_query($mysqli_link, $update_query)) {
        $mensaje_modificar = "Producto modificado exitosamente.";
    } else {
        $error_modificar = "Error al modificar el producto: " . mysqli_error($mysqli_link);
    }
}

// Eliminar Producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_producto'])) {
    $nombre_eliminar = $_POST['nombre_eliminar'];

    $delete_query = "DELETE FROM productos WHERE nombre = '$nombre_eliminar'";

    if (mysqli_query($mysqli_link, $delete_query)) {
        $mensaje_eliminar = "Producto eliminado exitosamente.";
    } else {
        $error_eliminar = "Error al eliminar el producto: " . mysqli_error($mysqli_link);
    }
}

// Obtener las categorías para el formulario de agregar desde la base de datos
$categorias_query_agregar = "SELECT id, nombre FROM categorias";
$categorias_result_agregar = mysqli_query($mysqli_link, $categorias_query_agregar);

// Obtener las categorías para el formulario de modificar desde la base de datos
$categorias_query_modificar = "SELECT id, nombre FROM categorias";
$categorias_result_modificar = mysqli_query($mysqli_link, $categorias_query_modificar);
?>