<?php
include 'auth.php';
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se recibió un ID válido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);

        // Consultar los datos del local
        $stmt = $conn->prepare("SELECT * FROM locales WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $local = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$local) {
            echo "No se encontró el local con ID $id.";
            exit;
        }
    } else {
        echo "ID no válido.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detalles del Local</h1>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= $local['id'] ?></td>
            </tr>
            <tr>
                <th>Nombre del Local</th>
                <td><?= $local['nombre_local'] ?></td>
            </tr>
            <tr>
                <th>Propietario</th>
                <td><?= $local['nombre_propietario'] ?></td>
            </tr>
            <tr>
                <th>Cédula</th>
                <td><?= $local['cedula'] ?></td>
            </tr>
            <tr>
                <th>Estado del Permiso</th>
                <td><?= $local['estado_permiso'] ?></td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td><?= $local['fecha_creacion'] ?></td>
            </tr>
            <tr>
                <th>Permiso Válido Desde</th>
                <td><?= $local['fecha_creacion'] ?></td>
            </tr>
            <tr>
                <th>Permiso Válido Hasta</th>
                <td><?= (new DateTime($local['fecha_creacion']))->modify('+1 year')->format('d/m/Y') ?></td>
            </tr>
        </table>
        <!-- <a href="consulta.php" class="btn btn-primary">Volver</a> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>