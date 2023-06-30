<?php
if (empty($_SESSION['active'])) {
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Panel de Administración</title>
    <link href="../assets/css/material-dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/header.css">
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>

<style>


  
  /*ESTILOS PARA TODA LA BARRA DE NAVEGACION*/
  .container1a {
    width: 100%;
    height: 19vh;
    color: #ffffff;
    background-color: #101a55;
  }
  
  /*ESTILOS PARA TODA LA BARRA DE NAVEGACION*/
  .navbar1a {
    width: 100%;                                                         
    margin: auto;
    padding: 50px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  
  /*ESTILOS PARA CADA UNO DE LOS ENLACES DE LA BARRA DE NAVEGACION*/
  .navbar1a .uls .lis {
    list-style: none;
    display: inline-block;
    margin: 0 15px;
    position: relative;
  }
  
  /*ESTILOS PARA LOS ENLACES ANIMACION*/
  .navbar1a .uls .lis::before { 
    content: "";
    height: 3px;
    width: 0%;
    background: #ffffff;
    position: absolute;
    left: 0;
    bottom: -12px;
    transition: 0.4s ease-out;
  }
  
  .navbar1a .uls .lis:hover::before {
    width: 100%;
  }
  
  /*ESTILOS PARA DAR ESTILO A LETRA (ENLACES DE NAVEGACION)*/
  .navbar1a .uls .lis .as {
    text-decoration: none;
    color: rgb(255, 255, 255);
    font-family: roboto, "sans-serif";
    font-size: 19px;
  }
  .icon-cogs {
      font-size: 4px;
      color: #101a55;
    }

</style>
</head>

<body>


    <div class="container1a">
        <nav class="navbar1a">
            

            <ul class="uls">
                <li class="lis">
                    <a class="as" href="usuarios.php">
                        USUARIO
                    </a>
                </li>
                
                <li class="lis">
                    <a class="as" href="proveedor.php">
                        
                        PROVEEDOR
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="productos.php">
                        PRODUCTOS
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="tipo.php">

                        LABORATORIO
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="categoria.php">

                        CATEGORIA
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="clientes.php">
    
                     CLIENTES
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="ventas.php">
                        
                        NUEVA VENTA
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="lista_ventas.php">
                
                        HISTORIAL VENTAS
                    </a>
                </li>
                <li class="lis">
                    <a class="as" href="alertas.php">
                    <i class="fas fa-bell mr-2"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <center><a class="navbar-brand" href="javascript:;"></a></center>
                </div>
                
                <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <p class="d-lg-none d-md-block">
                                Cuenta
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                            <a class="dropdown-item" href="#" data-toggle="modal"
                                data-target="#nuevo_pass">Contraseña</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="salir.php">Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>

                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="content bg">
            <div class="container-fluid">