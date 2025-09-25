<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if  (!isset($_SESSION)) {
    session_start();
}

function correoRegistro($destinatario)
{
    require '../vendor/autoload.php';
    
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

function correoReserva($destinatario,$protectora,$reserva)
{
    
    require '../vendor/autoload.php';
    
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
    $mail->Body = 'Gracias por reservar en Mafupets, tu reserva se encuentra en estado de confirmación, ' . $destinatario . ', en la protectora ' . $protectora['Nombre'] . '' . ' el día '.$reserva['FechaHora'].' para '.$reserva['Tipo'].'.';

    $mail->send();
}

function correoReservaProtectora($destinatario,$usuario,$reserva)
{
    
    require '../vendor/autoload.php';
    
    $usuario = obtenerUsuarioCorreo($usuario);
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
    $mail->Body = 'el usuario '.$usuario['Nombre'].' ha reservado el dia '.$reserva['FechaHora'].' para '.$reserva['Tipo'].' en la protectora '.$protectora['Nombre'].'.';

    $mail->send();
}

function correoReservaConfirmación($destinatario,$protectora,$reserva)
{
    
    require '../vendor/autoload.php';
    
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
    $mail->Body = 'Gracias por reservar en Mafupets, su reserva está confirmada, ' . $destinatario . ', en la protectora ' . $protectora['Nombre'] . ', la dirección es ' . $protectora['Ubicacion'] . '.';

    $mail->send();
}

function correoReservaCancelada($destinatario,$protectora,$reserva)
{
    
    require '../vendor/autoload.php';
    
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
    $mail->Body = 'Gracias por reservar en Mafupets, su reserva ha sido cancelada, ' . $destinatario . ', en la protectora ' . $protectora['Nombre'] . 'lo sentimos mucho que no pueda asistir a su visita.';

    $mail->send();
}