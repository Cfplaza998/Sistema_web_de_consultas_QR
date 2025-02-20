<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<style>
    /* Estilos personalizados para el navbar */
    .navbar {
        background-color: #2c2c2c; /* Fondo oscuro */
        border-bottom: 3px solid #d32f2f; /* Línea roja de los bomberos */
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffcc00; /* Amarillo brillante */
    }

    .navbar-brand:hover {
        color: #ffc107; /* Amarillo más claro al pasar el mouse */
    }

    .nav-link {
        color: #ffffff; /* Blanco para las opciones */
        font-size: 1rem;
        margin-right: 10px;
        transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #d32f2f; /* Rojo al pasar el mouse */
    }

    .nav-item .active {
        color: #ffcc00 !important; /* Amarillo brillante para el activo */
        font-weight: bold;
    }

    .navbar-toggler {
        border-color: #d32f2f; /* Rojo para el borde del toggler */
    }

    .dropdown-menu {
        background-color: #2c2c2c; /* Fondo oscuro del menú */
        border: 1px solid #d32f2f; /* Borde rojo */
    }

    .dropdown-item {
        color: #ffffff;
        transition: background-color 0.3s ease-in-out;
    }

    .dropdown-item:hover {
        background-color: #d32f2f; /* Fondo rojo al pasar el mouse */
        color: #ffffff;
    }

    .dropdown-divider {
        border-color: #d32f2f; /* Línea roja divisoria */
    }

    .navbar {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para destacar el navbar */
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">CBLTQR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="ingreso.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="consulta.php">Consultar Locales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crear_usuario.php">Crear Usuario</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?= $_SESSION['usuario'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
