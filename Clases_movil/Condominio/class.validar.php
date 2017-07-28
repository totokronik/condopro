<?php
session_start();
require "../../Datos/config.php";

$condominio = $_POST['condominio'];
$usuario = $_POST['usuario'];

$SP_Query = "call SP_PERFILAMIENTO_USUARIOS_CONDOMINIOS($usuario, $condominio)";

if($SP_Resultado = mysqli_query($conexion, $SP_Query)){
	while ($SP_Fila = $SP_Resultado->fetch_assoc()) {
		$SP_Valor = $SP_Fila['valor'];
	}
}


header('Location: ../../Vistas_movil/pages/index.php');
$_SESSION['perfil'] = $SP_Valor;
$_SESSION['condominio'] = $condominio;
?>