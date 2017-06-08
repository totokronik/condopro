<?php
  
require_once ('Utilities/Mobile_Detect/Mobile_Detect.php');
$detect = new Mobile_Detect();

if (!$detect->isiOS() || !$detect->isAndroidOS() || !$detect->isTablet() || !$detect->isMobile())
{
  
  header("location: Vistas/pages/login.html");
   
}


if ($detect->isMobile()) {
// Detecta si es un móvil
 header("location: Vistas/pages/login_movil.html");
 }
if ($detect->isTablet()) {
// Si es un tablet
    header("location: Vistas/pages/login_movil.html");
 }
if ($detect->isAndroidOS()) {
// Si es Android
    header("location: Vistas/pages/login_movil.html");
 
}

if ($detect->isiOS()){
 //Si es iOS
   header("location: Vistas/pages/login_movil.html");
 }


?>