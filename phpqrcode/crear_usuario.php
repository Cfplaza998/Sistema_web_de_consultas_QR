<?php
include 'navbar.php';
include 'header.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, username, password) VALUES (:nombre, :username, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $success = "Usuario creado con éxito.";
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}
?>

<div class="container mt-5">
    <!-- Card para el formulario de creación de usuario -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Crear Nuevo Usuario</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="crear_usuario.php">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Enlace para volver al inicio -->
    <div class="mt-3 text-center">
        <a href="index.php" class="btn btn-link">Volver al Inicio</a>
    </div>
</div>

<?php include 'footer.php'; ?>
