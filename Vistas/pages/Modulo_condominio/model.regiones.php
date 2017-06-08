<?php

require "../../../Datos/config.php";

$id_region = $_POST['id_region'];
$RG_Query = "SELECT id_comuna, nombre_comuna FROM comunas WHERE id_region = $id_region";
$RG_Resultado = $conexion->query($RG_Query);

$html = "<option value='0'>Seleccionar comuna</option>";

while ($RG_Fila = $RG_Resultado->fetch_assoc()) {
    $html .= "<option value='".$RG_Fila['id_comuna']."'>".$RG_Fila['nombre_comuna']."</option>";
}

echo $html;
?>

