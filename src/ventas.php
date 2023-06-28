<?php
session_start();
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "nueva_venta";
$sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = ? AND p.nombre = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "is", $id_user, $permiso);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$existe = mysqli_fetch_all($result);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
    exit();
}

if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $proveedor = $_POST['proveedor'];
    $fechahoy = $_POST['fechahoy'];
    $vencimiento = $_POST['vencimiento'];
    $reginv = $_POST['reginv'];
    $nolote = $_POST['nolote'];
    $dosis = $_POST['dosis'];
    $funcion = $_POST['funcion'];
    if (!empty($_POST['accion'])) {
        $vencimiento = $_POST['vencimiento'];
    }
    
    // Registrar datos del cliente en la tabla "cliente"
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $query_cliente = mysqli_query($conexion, "INSERT INTO cliente (nombre, telefono, direccion) VALUES ('$nombre', '$telefono', '$direccion')");
    
    // Obtener el ID del cliente recién insertado
    $idcliente = mysqli_insert_id($conexion);

    // Verificar si el campo del producto está vacío
    if (empty($producto)) {
        echo "No hay producto para generar la venta.";
    } else {
        // Registrar datos de la venta en la tabla "ventas"
        $query_venta = mysqli_query($conexion, "INSERT INTO ventas (codigo, producto, precio, cantidad, idcliente) VALUES ('$codigo', '$producto', $precio, $cantidad, $idcliente)");

        if ($query_venta && mysqli_affected_rows($conexion) > 0) {
            // Se pudo generar la venta y se actualizó al menos un registro
            echo "Venta generada correctamente.";
        } else {
            // No se pudo generar la venta o no se actualizó ningún registro
            echo "No se pudo generar la venta.";
        }
    }
}
include_once "includes/header.php";
?>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <h4 class="text-center">Datos del Cliente</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                                <label class=" text-dark font-weight-bold">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    placeholder="Ingrese nombre del cliente" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=" text-dark font-weight-bold">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=" text-dark font-weight-bold">Teléfono</label>
                                <input type="number" name="telefono" id="telefono" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=" text-dark font-weight-bold">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                Buscar Productos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="producto" class=" text-dark font-weight-bold">Código o Nombre</label>
                            <input id="producto" class="form-control" type="text" name="producto"
                                placeholder="Ingresa el código o nombre">
                            <input id="id" type="hidden" name="id">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="cantidad" class=" text-dark font-weight-bold">Cantidad</label>
                            <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad"
                                onkeyup="calcularPrecio(event)">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="precio" class=" text-dark font-weight-bold">Precio</label>
                            <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio"
                                disabled>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="sub_total" class=" text-dark font-weight-bold">Sub Total</label>
                            <input id="sub_total" class="form-control" type="text" name="sub_total"
                                placeholder="Sub Total" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-6">
            <a href="#" class="btn btn-primary" id="btn_generar"><i class="fas fa-save"></i> Generar Venta</a>
        </div>
        <br><br>
        <div class="table-responsive">
            <table class="table table-hover" id="tblDetalle">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Aplicar</th>
                        <th>Desc</th>
                        <th>Precio</th>
                        <th>Precio Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="detalle_venta">
                    <!-- Aquí se agregarán los elementos de la venta -->
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total a Pagar</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>