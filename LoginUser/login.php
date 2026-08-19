<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Suministros S.A.</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-image-wrapper">
                <img src="../menuprincipal/dfctrack.jpg" onerror="this.src='../Productos/dfctrack.jpg'" alt="Logo Suministros S.A.">
            </div>
            <h2>SUMINISTROS S.A.</h2>
            <p class="subtitle">Portal de Gestión y Control Empresarial</p>
        </div>

        <form action="procesar_login.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="usuario" placeholder="Usuario o correo" required autocomplete="username">
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Contraseña de acceso" required autocomplete="current-password">
            </div>
            <button type="submit"><i class="fas fa-arrow-right-to-bracket"></i> Iniciar Sesión</button>
        </form>
        <p class="register-link">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
