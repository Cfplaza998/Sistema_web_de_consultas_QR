<?php
include 'navbar.php';
include 'header.php';
?>

<div class="container mt-5">
    <!-- Card para el formulario de ingreso de datos -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Formulario de Almacenamiento</h5>
        </div>
        <div class="card-body">
            <!-- Formulario -->
            <form id="datosForm" method="POST" action="guardar.php">
                <div class="mb-3">
                    <label for="nombreLocal" class="form-label">Nombre del Local Comercial:</label>
                    <input type="text" id="nombreLocal" name="nombreLocal" class="form-control" placeholder="Ingrese el nombre del local" required>
                </div>

                <div class="mb-3">
                    <label for="nombrePropietario" class="form-label">Nombre del Propietario:</label>
                    <input type="text" id="nombrePropietario" name="nombrePropietario" class="form-control" placeholder="Ingrese el nombre del propietario" required>
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">Número de Cédula:</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Ingrese el número de cédula" required pattern="\d{10}" title="Debe contener 10 dígitos">
                </div>

                <div class="mb-3">
                    <label for="estadoPermiso" class="form-label">Estado del Permiso:</label>
                    <select id="estadoPermiso" name="estadoPermiso" class="form-select" required>
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="PENDIENTE">PENDIENTE</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Enlace a la página de consulta -->
    <div class="mt-3">
        <a href="consulta.php" class="btn btn-link">Consultar Locales Registrados</a>
    </div>
</div>

<?php include 'footer.php'; ?>
