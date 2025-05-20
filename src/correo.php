<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function correoRegistro($destinatario)
{
    require '../vendor/autoload.php';
    session_start();
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mafupets@gmail.com'; // Tu correo
    $mail->Password   = 'asyh gqmm gnte rsxp'; // Contraseña o App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    
    $mail->setFrom('mafupets@gmail.com', 'Mafupets');
    //variable sesión
    $mail->addAddress($destinatario);

    $mail->isHTML(true);
    $mail->Subject = 'Gracias por registrarte en Mafupets';
        
    // Construir el cuerpo del mensaje correctamente
    $mail->Body = 'Gracias por registrarte en Mafupets ' . $destinatario . ', disfruta de nuestra plataforma.';

    $mail->send();
}

function correoReserva($destinatario,$protectora)
{
    require '../vendor/autoload.php';
    session_start();
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mafupets@gmail.com'; // Tu correo
    $mail->Password   = 'asyh gqmm gnte rsxp'; // Contraseña o App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    
    $mail->setFrom('mafupets@gmail.com', 'Mafupets');
    //variable sesión
    $mail->addAddress($destinatario);

    $mail->isHTML(true);
    $mail->Subject = 'Gracias por reservar en Mafupets';
        
    // Construir el cuerpo del mensaje correctamente
    $mail->Body = 'Gracias por reservar en Mafupets ' . $destinatario . ', en la protectora ' . $protectora['Nombre'] . ', la dirección es ' . $protectora['Ubicacion'] . '.';

    $mail->send();
}