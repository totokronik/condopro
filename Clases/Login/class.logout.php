<?php 
	session_start();
	session_destroy();
	header('Location: ../../Vistas/pages/login.html');
?>