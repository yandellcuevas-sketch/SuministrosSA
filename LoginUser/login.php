<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="procesar_login.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <p class="register-link">¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
    </div>
</body>
</html>
