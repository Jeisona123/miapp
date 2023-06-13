<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: src/');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
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
    <title>Iniciar Sesión</title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="./assets/css/indexlogin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" />
</head>

<body>
    <div class="form">

        <h2 class="title">INICIAR SESION</h2><br><br>
        <div class="alert <?php echo isset($alert) ? 'show' : ''; ?>">
            <?php echo isset($alert) ? $alert : ''; ?>
        </div>

        <br>
        <form action="" method="post" class="p-3">
            <div class="form-group">
                <i class="fa-solid fa-user"></i>
                <label>Usuario</label>
                <input type="text" class="form-control form-control-lg text-center" id="exampleInputEmail1"
                    placeholder="Usuario" name="usuario">
            </div>
            <div class="form-group">
                <i class="fa-solid fa-unlock"></i>
                <label>Clave</label>
                <input type="password" class="form-control form-control-lg text-center" id="exampleInputPassword1"
                    placeholder="Clave" name="clave">
            </div>
            <button class="botona" type="submit">Login</button>
            <a class="otro" href="#">Crear Cuenta</a>

        </form>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/js/material-dashboard.js"></script>
    <!-- endinject -->
</body>

</html>