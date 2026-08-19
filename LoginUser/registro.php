<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Registro</h2>
        <form action="procesar_registro.php" method="POST">
            <div class="input-group">
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <p class="register-link">¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
    </div>
</body>
</html>
