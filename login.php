<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="post" action="BD_login.php">
        <label>RUT:</label>
        <input type="text" name="rut" required><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>