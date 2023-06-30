<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}

// Alerta de vencimiento
$alert_vencimiento = '';
$fecha_actual = date('Y-m-d');
$query_vencimiento = mysqli_query($conexion, "SELECT * FROM producto WHERE vencimiento <= '$fecha_actual'");
$num_productos_vencidos = mysqli_num_rows($query_vencimiento);

// Alerta de cantidad baja
$alert_cantidad_baja = '';
$min_cantidad = 10; // Cantidad mínima para generar alerta

$query_cantidad_baja = mysqli_query($conexion, "SELECT * FROM producto WHERE cantidad <= $min_cantidad");
$num_productos_cantidad_baja = mysqli_num_rows($query_cantidad_baja);

include_once "includes/header.php";
?>

<!-- Contenido de la página -->

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card-header bg-primary text-white">
                ALERTA DE VENCIMIENTO
            </div><br>
            <?php if ($num_productos_vencidos > 0): ?>
                <div class="alert alert-danger" role="alert">

                    Los siguientes productos han vencido:<br>
                    <?php while ($producto = mysqli_fetch_assoc($query_vencimiento)): ?>
                        <?php $nombre_producto = $producto['descripcion']; ?><br><br>
                        <i class="fas fa-exclamation-circle mr-2 text-danger"></i>
                        <?php echo $nombre_producto; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <div class="card-header bg-primary text-white">
                ALERTA DE STOCK
            </div><br>
            <?php if ($num_productos_cantidad_baja > 0): ?>
                <div class="alert alert-warning" role="alert">

                    Productos que tienen cantidad baja en el inventario:<br>
                    <?php while ($producto = mysqli_fetch_assoc($query_cantidad_baja)): ?>
                        <?php $nombre_producto = $producto['descripcion']; ?><br><br>
                        <i class="fas fa-exclamation-circle mr-2 text-danger"></i>
                        <?php echo $nombre_producto; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Resto del contenido de la página -->
</div>

<?php include_once "includes/footer.php"; ?>