<?php 
session_start();
require "../../Datos/config.php";

if(isset($_SESSION['loggedin'])){
}else{
    echo "<script>alert('Está página es solo para usuarios registrados'); javascript:history.back()</script>";
}

$usuario = $_SESSION['id_usuario'];


# Consulta que indica si existe algún registro en la tabla condominios
$consulta_existe = "SELECT * FROM condominios WHERE activo = 1";
$resultado_existe = mysqli_query($conexion, $consulta_existe);

if(mysqli_num_rows($resultado_existe) == 0){
    echo "<script>alert('No hay condominios en el sistema. Favor ingresar el primer condominio'); javascript:history.back()'</script>";
} 


#Declarar consultas
$consulta_user_normal = "SELECT
                        cn.id_condominio,
                        cn.nombre_condominio
                        FROM
                        condominios AS cn
                        INNER JOIN estructura_condominio AS ec ON cn.id_condominio = ec.id_condominio
                        INNER JOIN residente_condominio AS rc ON ec.id_estructura_condominio = rc.id_estructura_condominio
                        WHERE
                        rc.id_usuario = $usuario and
                        cn.activo = 1
                        GROUP BY cn.id_condominio";

$consulta_master_user = "SELECT id_condominio, nombre_condominio FROM condominios WHERE activo = 1";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CONDOPRO</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <center><img src="../img/logo_movil.png"></center>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="../../Clases_movil/Condominio/class.validar.php" method="POST">
                            <fieldset>
                                <div class="form-group input-group">
                                    <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                                    <span class="input-group-addon"><i class="fa fa-home fa-fw"></i></span>
                                    <select name="condominio" class="form-control">
                                        <?php 

                                        if($usuario == 0){
                                        	 $resultado_master_user = $conexion->query($consulta_master_user);
                                           
                                            while ($fila_master_user = $resultado_master_user->fetch_assoc()) {
                                                echo "<option value=".$fila_master_user['id_condominio'].">".$fila_master_user['nombre_condominio']."</option>";
                                            }
                                       	}else{
                                       		$resultado_user_normal = $conexion->query($consulta_user_normal);
                                            while ($fila_user_normal = $resultado_user_normal->fetch_assoc()) {
                                                echo "<option value=".$fila_user_normal['id_condominio'].">".$fila_user_normal['nombre_condominio']."</option>";
                                            }
                                       	}
                                       	?>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Seleccionar">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
