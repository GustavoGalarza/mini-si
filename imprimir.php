<?php

require('fpdf186/fpdf.php');

// Función para generar un PDF
function generatePDF($data) {
    $pdf = new FPDF('P', 'mm', 'Letter'); // Orientación vertical y tamaño de página Letter (8.5x11 pulgadas)
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 8); // Tamaño de fuente reducido

    // Título de la página
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(0, 10, 'Registro de Venta', 1, 0, 'C', 1);
    $pdf->Ln(15); // Espacio después del título

    // Encabezado del PDF
    $pdf->Cell(15, 8, 'ID', 1);
    $pdf->Cell(15, 8, 'Fecha', 1);
    $pdf->Cell(20, 8, 'RUT Cliente', 1);
    $pdf->Cell(25, 8, 'Nombre Cliente', 1);
    $pdf->Cell(15, 8, 'Dir Calle', 1);
    $pdf->Cell(15, 8, 'Dir Número', 1);
    $pdf->Cell(15, 8, 'Dir Comuna', 1);
    $pdf->Cell(15, 8, 'Dir Ciudad', 1);
    $pdf->Cell(15, 8, 'Monto', 1);
    $pdf->Cell(15, 8, 'Descuento', 1);
    $pdf->Cell(20, 8, 'Teléfonos', 1);
    $pdf->Ln();

    foreach ($data as $row) {
        $pdf->Cell(15, 8, $row["id"], 1);
        $pdf->Cell(15, 8, $row["fecha"], 1);
        $pdf->Cell(20, 8, $row["rut_cliente"], 1);
        $pdf->Cell(25, 8, $row["nombre_cliente"], 1);
        $pdf->Cell(15, 8, $row["direccion_calle"], 1);
        $pdf->Cell(15, 8, $row["direccion_numero"], 1);
        $pdf->Cell(15, 8, $row["direccion_comuna"], 1);
        $pdf->Cell(15, 8, $row["direccion_ciudad"], 1);
        $pdf->Cell(15, 8, '$' . $row["monto_final"], 1);
        $pdf->Cell(15, 8, $row["descuento"] . "%", 1);
        $pdf->Cell(20, 8, $row["telefonos"], 1);
        $pdf->Ln();
    }

    // Salida del PDF al navegador
    $pdf->Output();
}

$mysqli = new mysqli("localhost", "root", "", "gestion_ventas");
if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

$data = array(); // Array para almacenar los datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mostrar todas las ventas de todos los clientes
    if (isset($_POST["imprimir_todas_las_ventas"])) {
        $sql_todas_las_ventas = "SELECT venta.*, clientes.nombre AS nombre_cliente, clientes.direccion_calle, clientes.direccion_numero, clientes.direccion_comuna, clientes.direccion_ciudad, GROUP_CONCAT(telefonos_clientes.telefono) AS telefonos FROM venta LEFT JOIN clientes ON venta.rut_cliente = clientes.rut LEFT JOIN telefonos_clientes ON venta.rut_cliente = telefonos_clientes.rut_cliente GROUP BY venta.id";
        $result_todas_las_ventas = $mysqli->query($sql_todas_las_ventas);

        if ($result_todas_las_ventas->num_rows > 0) {
            while ($row_venta = $result_todas_las_ventas->fetch_assoc()) {
                $data[] = $row_venta;
            }
        }
    }

    // Mostrar detalles de una venta específica
    if (isset($_POST["imprimir_venta_mostrar"])) {
        $id_venta_mostrar = $_POST["imprimir_venta_mostrar"];

        // Consulta SQL para obtener la información de la venta
        $sql_venta = "SELECT venta.*, clientes.nombre AS nombre_cliente, clientes.direccion_calle, clientes.direccion_numero, clientes.direccion_comuna, clientes.direccion_ciudad, GROUP_CONCAT(telefonos_clientes.telefono) AS telefonos FROM venta LEFT JOIN clientes ON venta.rut_cliente = clientes.rut LEFT JOIN telefonos_clientes ON venta.rut_cliente = telefonos_clientes.rut_cliente WHERE venta.id = '$id_venta_mostrar' GROUP BY venta.id";
        $result_venta = $mysqli->query($sql_venta);

        if ($result_venta->num_rows > 0) {
            while ($row_venta = $result_venta->fetch_assoc()) {
                $data[] = $row_venta;
            }
        }
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generar el PDF si se hizo una solicitud POST
    generatePDF($data);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>UAJMS-Informatica</title>
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
    
    <!-- Formulario para mostrar venta y detalles -->
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h2>Mostrar Registro de Venta y Detalles de Venta</h2>
        <label for="imprimir_venta_mostrar">Selecciona un ID de Venta:</label>
        <select name="imprimir_venta_mostrar" required>
            <?php
            // Rellenar el select con IDs de venta disponibles
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
        <input type="submit" value="Imprimir Venta y Detalles">
    </form>
<br>
    <!-- Botón para mostrar todas las ventas -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h2>Imprimir todas las ventas registradas</h2>
        <input type="hidden" name="imprimir_todas_las_ventas">
        <input type="submit" value="Imprimir Todas las Ventas">
    </form>

    <!-- Enlace para descargar el PDF -->
    <?php if (!empty($data)): ?>
        <a href="<?php echo $_SERVER['PHP_SELF'] . '?generate_pdf=1'; ?>">Descargar PDF</a>
    <?php endif; ?>
    </div>
    <div class="footer">Gustavo Rafael Galarzar Arias</div>
</body>
</html>
