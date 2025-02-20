<?php
include 'navbar.php';
include 'header.php';

$id = $_GET['id'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del local por ID
    $stmt = $conn->prepare("SELECT * FROM locales WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $local = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar datos del local
    $nombre_local = $_POST['nombre_local'];
    $nombre_propietario = $_POST['nombre_propietario'];
    $cedula = $_POST['cedula'];
    $estado_permiso = $_POST['estado_permiso'];

    try {
        $stmt = $conn->prepare("UPDATE locales SET nombre_local = :nombre_local, nombre_propietario = :nombre_propietario, cedula = :cedula, estado_permiso = :estado_permiso WHERE id = :id");
        $stmt->bindParam(':nombre_local', $nombre_local);
        $stmt->bindParam(':nombre_propietario', $nombre_propietario);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':estado_permiso', $estado_permiso);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Local actualizado correctamente'); window.location.href='consulta.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Local</title>
    <!-- Incluir Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Editar Información del Local</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nombre_local" class="form-label">Nombre del Local:</label>
                                <input type="text" id="nombre_local" name="nombre_local" class="form-control" value="<?= $local['nombre_local'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_propietario" class="form-label">Nombre del Propietario:</label>
                                <input type="text" id="nombre_propietario" name="nombre_propietario" class="form-control" value="<?= $local['nombre_propietario'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="cedula" class="form-label">Cédula:</label>
                                <input type="text" id="cedula" name="cedula" class="form-control" value="<?= $local['cedula'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado_permiso" class="form-label">Estado del Permiso:</label>
                                <select id="estado_permiso" name="estado_permiso" class="form-select" required>
                                    <option value="Válido" <?= $local['estado_permiso'] === 'Válido' ? 'selected' : '' ?>>Válido</option>
                                    <option value="Vencido" <?= $local['estado_permiso'] === 'Vencido' ? 'selected' : '' ?>>Vencido</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <a href="consulta.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluir JS de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
