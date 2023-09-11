<!DOCTYPE html>
<html>
<head>
    <title>Registro de Cliente</title>
</head>
<body>
    <h2>Registro de Cliente</h2>
    <form method="post" action="registro_cliente.php">
        <label>RUT:</label>
        <input type="text" name="rut" required><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label>Dirección - Calle:</label>
        <input type="text" name="direccion_calle" required><br>

        <label>Dirección - Número:</label>
        <input type="text" name="direccion_numero" required><br>

        <label>Dirección - Comuna:</label>
        <input type="text" name="direccion_comuna" required><br>

        <label>Dirección - Ciudad:</label>
        <input type="text" name="direccion_ciudad" required><br>

        <input type="submit" value="Registrar">
    </form>
    <p><a href="login.php">Ya tienes una cuenta? Logeate</a></p>
</body>
</html>