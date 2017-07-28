<?php
include "class.phpmailer.php";
include "class.smtp.php";

#function enviarmail($mail, $asunto, $cuerpo){
function enviarmail(){

$email_user = "ing.ovelascoreyes@gmail.com";
$email_password = "Toto-2692082";
$the_subject = "Phpmailer prueba CondoPro";
$address_to = "o.velasco.r@gmail.com";
$from_name = "CondoPro";
$phpmailer = new PHPMailer();

// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//-----------------------------------------------------------------------
// $phpmailer->SMTPDebug = 1;
$phpmailer->SMTPSecure = 'ssl';
$phpmailer->Host = "smtp.gmail.com"; // GMail
$phpmailer->Port = 465;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;

$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // recipients email

$phpmailer->Subject = $the_subject;	
$phpmailer->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
$phpmailer->Body .= "<p>El cuerpo del mensaje de prueba/p>";
$phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
$phpmailer->IsHTML(true);

$phpmailer->Send();
}
?>