<?php
include 'navbar.php';
include 'header.php';
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener todos los locales
    $stmt = $conn->prepare("SELECT * FROM locales");
    $stmt->execute();

    // Almacenar los resultados en la variable $locales
    $locales = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Consulta de Locales</title>

    <!-- Incluir CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        canvas {
            display: block;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Card para la consulta de locales -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Consulta de Locales Registrados</h5>
            </div>
            <div class="card-body">
                <!-- Tabla de DataTables dentro de la card -->
                <table id="localesTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Local</th>
                            <th>Propietario</th>
                            <th>Cédula</th>
                            <th>Estado</th>
                            <th>Fecha de Creación</th>
                            <th>Permiso Valido Desde</th>
                            <th>Permiso Valido Hasta</th>
                            <th>QR</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($locales) && !empty($locales)): ?>
                            <?php foreach ($locales as $local): ?>
                                <?php
                                    // Calcular la fecha de caducidad (un año después de la fecha de creación)
                                    $fecha_creacion = new DateTime($local['fecha_creacion']);
                                    $fecha_caducidad = clone $fecha_creacion;
                                    $fecha_caducidad->modify('+1 month');
                                ?>
                                <tr>
                                    <td><?= $local['id'] ?></td>
                                    <td><?= $local['nombre_local'] ?></td>
                                    <td><?= $local['nombre_propietario'] ?></td>
                                    <td><?= $local['cedula'] ?></td>
                                    <td><?= $local['estado_permiso'] ?></td>
                                    <td><?= $fecha_creacion->format('d/m/Y') ?></td>
                                    <td><?= $fecha_creacion->format('d/m/Y') ?></td>
                                    <td><?= $fecha_caducidad->format('d/m/Y') ?></td>
                                    <td>
                                        <div id="qrcode-<?= $local['id'] ?>"></div>
                                        <script>
                                            const qrcode<?= $local['id'] ?> = new QRCode(document.getElementById("qrcode-<?= $local['id'] ?>"), {
                                                text: 'http://192.168.0.104/GENERADOR_QR/detalles.php?id=<?= $local['id'] ?>',
                                                width: 150,
                                                height: 150
                                            });
                                             // Esperar a que el QR se genere
                                            setTimeout(() => {
                                                const canvas = qrContainer.querySelector("canvas");
                                                const ctx = canvas.getContext("2d");

                                                // Cargar el logo
                                                const logo = new Image();
                                                logo.src = "img/LOGO.jpg"; // Ruta del logo
                                                logo.onload = () => {
                                                    const logoSize = 40; // Tamaño del logo
                                                    const centerX = (canvas.width - logoSize) / 2;
                                                    const centerY = (canvas.height - logoSize) / 2;

                                                    // Dibujar el logo en el centro del QR
                                                    ctx.drawImage(logo, centerX, centerY, logoSize, logoSize);
                                                };
                                            }, 500); // Esperar para asegurar que el QR esté completamente generado
                                        </script>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <button class="btn btn-success btn-sm" onclick="descargarQR(<?= $local['id'] ?>, '<?= $local['nombre_local'] ?>')">Descargar QR</button>
                                            <a href="editar.php?id=<?= $local['id'] ?>" class="btn btn-warning btn-sm text-white">Editar</a>
                                            <button class="btn btn-danger btn-sm" onclick="eliminarLocal(<?= $local['id'] ?>)">Eliminar</button>
                                            <a href="imprimir.php?id=<?= $local['id'] ?>" class="btn btn-primary btn-sm">Imprimir</a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">No hay locales registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Botón para volver al generador -->
                <a href="ingreso.php" class="btn btn-primary mt-3">Volver al Generador</a>
            </div>
        </div>
    </div>

    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('#localesTable').DataTable();  // Inicializar DataTable
        });

        // Función para descargar el QR
        function descargarQR(id, nombreLocal) {
            const canvas = document.querySelector(`#qrcode-${id} canvas`);
            const link = document.createElement('a');
            link.download = `QR_${nombreLocal}.png`;
            link.href = canvas.toDataURL();
            link.click();
        }

        // Función para editar un local
        function editarLocal(id) {
            // Redirige a una página de edición con el ID del local
            window.location.href = `editar.php?id=${id}`;
        }

        // Función para eliminar un local
        function eliminarLocal(id) {
            // Confirmación del usuario
            if (confirm("¿Estás seguro de que deseas eliminar este local? Esta acción no se puede deshacer.")) {
                // Realizar solicitud a eliminar.php
                fetch(`eliminar.php?id=${id}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Local eliminado correctamente.");
                        location.reload(); // Recarga la página
                    } else {
                        alert("Ocurrió un error al eliminar el local.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }

    </script>

    <!-- Incluir JS de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
