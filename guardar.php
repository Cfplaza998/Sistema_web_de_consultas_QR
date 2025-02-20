<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $nombreLocal = $_POST['nombreLocal'];
    $nombrePropietario = $_POST['nombrePropietario'];
    $cedula = $_POST['cedula'];
    $estadoPermiso = $_POST['estadoPermiso'];
    $numeroPermiso = "PERM-" . rand(1000, 9999);

    // Crear datos QR
    $qrData = json_encode([
        "local" => $nombreLocal,
        "propietario" => $nombrePropietario,
        "cedula" => $cedula,
        "permiso" => $numeroPermiso,
        "estado" => $estadoPermiso . " (" . date("Y") . ")"
    ]);

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO locales (nombre_local, nombre_propietario, cedula, numero_permiso, estado_permiso, qr_data)
                            VALUES (:nombre_local, :nombre_propietario, :cedula, :numero_permiso, :estado_permiso, :qr_data)");
    $stmt->bindParam(':nombre_local', $nombreLocal);
    $stmt->bindParam(':nombre_propietario', $nombrePropietario);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':numero_permiso', $numeroPermiso);
    $stmt->bindParam(':estado_permiso', $estadoPermiso);
    $stmt->bindParam(':qr_data', $qrData);
    $stmt->execute();

    echo "<script>alert('Local registrado exitosamente'); window.location.href='consulta.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
