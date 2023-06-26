<?php
$conexion = mysqli_connect("localhost", "root", "", "miapp");

if (!$conexion) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

$permiso = 'usuarios';

if (!empty($_POST)) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $alert = "";

    if (empty($nombre) || empty($email) || empty($user)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todos los campos son obligatorios
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        if (empty($id)) {
            $clave = $_POST['clave'];

            if (empty($clave)) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    La contraseña es requerida
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $clave = md5($_POST['clave']);

                $email = mysqli_real_escape_string($conexion, $email); // Sanitize the email input
                $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo = '$email'");
                if (mysqli_num_rows($query) > 0) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    El correo ya existe
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre, correo, usuario, clave) VALUES ('$nombre', '$email', '$user', '$clave')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Registrado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    } else {
                        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al registrar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    }
                }
            }
        } else {
            $nombre = mysqli_real_escape_string($conexion, $nombre); // Sanitize the inputs
            $email = mysqli_real_escape_string($conexion, $email);
            $user = mysqli_real_escape_string($conexion, $user);

            $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$email', usuario = '$user' WHERE idusuario = $id");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Modificado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al modificar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crear Cuenta</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/css/indexlogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/crear.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" />
</head>

<body>
    <div class="card">
        <div class="card-body">
        
            <form action="" method="post" autocomplete="off" id="formulario">
                <?php echo isset($alert) ? $alert : ''; ?>
                <h2 class="title">CREAR CUENTA </h2><br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <i class="fa-solid fa-user"></i>
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre">
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <i class="fa fa-envelope"></i>
                        <label for="correo">Correo</label>
                            <input type="email" class="form-control" placeholder="Correo Electrónico" name="correo" id="correo">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <i class="fa-solid fa-user"></i>
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <i class="fa-solid fa-unlock"></i>
                            <label for="clave">Contraseña</label>
                            <input type="password" class="form-control" placeholder="Password" name="clave" id="clave">
                        </div>
                    </div>
                </div><br>
                <button class="botona" type="submit">Crear Cuenta</button>
                <a class="otros" href="index.php">Ya tengo una cuenta</a>
            </form>
        </div>
    </div>
</body>

</html>
