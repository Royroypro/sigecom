<?php

include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');
include ('../app/controllers/proveedor/listado_de_proveedor.php');

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title>Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>

	<!-- Content page -->
	<div class="container-fluid">
		<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Lista <small>PROVEEDORES</P></small></h1>
		</div>
	</div>

	<div class="container-fluid">
		<ul class="breadcrumb breadcrumb-tabs">
			<li>
				<a href="crear.php" class="btn btn-info">
					<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO PROVEEDOR
				</a>
			</li>
		</ul>
	</div>

    <div class="container-fluid">
		<ul class="breadcrumb breadcrumb-tabs">
			<li>
				<a href="<?php echo $URL; ?>/app/controllers/proveedor/generar_pdf.php" target="_blank" class="btn btn-info">
					<i class="zmdi zmdi-file-pdf"></i> &nbsp; GENERAR PDF
				</a>
			</li>
			<li>
				<a href="<?php echo $URL; ?>/app/controllers/proveedor/generar_exel.php" target="_blank" class="btn btn-success">
					<i class="zmdi zmdi-file-excel"></i> &nbsp; GENERAR EXCEL
				</a>
			</li>
		</ul>
	</div>
	
	<!-- Panel listado de proveedores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PROVEEDORES</h3>
        </div>
        <form method="GET" action="" class="estado-filter-form">
            <label for="filtroEstado">Mostrar:</label>
            <select id="filtroEstado" name="filtroEstado" class="form-control estado-filter-select" onchange="this.form.submit()">
                <option value="todos" <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] == 'todos') ? 'selected' : ''; ?>>Mostrar ambos</option>
                <option value="activos" <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] == 'activos') ? 'selected' : ''; ?>>Mostrar solo activos</option>
                <option value="inactivos" <?php echo (isset($_GET['filtroEstado']) && $_GET['filtroEstado'] == 'inactivos') ? 'selected' : ''; ?>>Mostrar solo inactivos</option>
            </select>
        </form>

        <?php
            $filtroEstado = isset($_GET['filtroEstado']) ? $_GET['filtroEstado'] : 'todos';

            // Filtra según el estado seleccionado
            $query = "SELECT * FROM proveedor";
            if ($filtroEstado == 'activos') {
                $query .= " WHERE Estado = 1";
            } elseif ($filtroEstado == 'inactivos') {
                $query .= " WHERE Estado = 0";
            }

            // Ejecuta la consulta
            $proveedores = $pdo->query($query);
        ?>
        <div class="panel-body">
            <div class="table-responsive">
                
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Dirección</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">EDITAR</th>
                        <th class="text-center">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($proveedores as $fila) {
                    ?>
                    <tr>
                        <td><?php echo isset($contador) ? ++$contador : ($contador = 1); ?></td>
                        <td><?php echo $fila['ID_proveedor']; ?></td>
                        <td><?php echo $fila['Nombre']; ?></td>
                        <td><?php echo $fila['Dirección']; ?></td>
                        <td><?php echo $fila['Teléfono']; ?></td>
                        <td style="color: <?php echo $fila['Estado'] == 1 ? 'green' : 'red'; ?>"><?php echo $fila['Estado'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-raised btn-xs" onclick="openModal('editarModalProveedor<?php echo $fila['ID_proveedor']; ?>')">
                                <i class="zmdi zmdi-edit"></i>
                            </button>
                            <?php 
                            $id_proveedor = $fila['ID_proveedor']; 
                            include 'funciones.php';
                            ?>
                        </td>
                        <td>
                        <form action="<?php echo $URL; ?>/app/controllers/proveedor/eliminar.php" method="post" onsubmit="return confirmacionEliminar(event, this);">
                                <input type="hidden" name="id_proveedor" value="<?php echo $fila['ID_proveedor']; ?>">
                                <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                        </form>



                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($_GET['success']); ?>
                            </div>
                        <?php endif; ?>
			<script src="<?php echo $URL; ?>/js/funciones_proveedor.js"></script>
            </div>
            <nav class="text-center">
                <ul class="pagination pagination-sm">
                <li><a href="javascript:void(0)">«</a></li>
                    <li><a href="javascript:void(0)">1</a></li>
                    <li><a href="javascript:void(0)">2</a></li>
                    <li><a href="javascript:void(0)">3</a></li>
                    <li><a href="javascript:void(0)">4</a></li>
                    <li><a href="javascript:void(0)">5</a></li>
                    <li><a href="javascript:void(0)">»</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

</section>

</body>
</html>



<script>
function confirmacionEliminar(e, form) {
    e.preventDefault(); // Prevenir el envío del formulario por defecto

    // Mostrar el modal de confirmación
    var modal = document.getElementById("customConfirmModal");
    modal.style.display = "block";

    // Configurar el comportamiento del botón de confirmación
    document.getElementById("confirmDelete").onclick = function() {
        form.submit(); // Enviar el formulario si el usuario confirma
    };

    // Configurar el comportamiento del botón de cancelación
    document.getElementById("cancelDelete").onclick = function() {
        modal.style.display = "none"; // Cerrar el modal si el usuario cancela
    };

    // Cerrar el modal si el usuario hace clic fuera de él
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}




