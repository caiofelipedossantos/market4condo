<?php
header('Content-Type: application/json');

// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carregar o autoloader do composer
require './vendor/autoload.php';


if (
    !isset($_POST['name']) && empty($_POST['name']) &&
    !isset($_POST['phone']) && empty($_POST['phone']) &&
    !isset($_POST['email']) && empty($_POST['email']) &&
    !isset($_POST['message']) && empty($_POST['message'])
) {
    echo json_encode(['status' => false, 'message' => 'Campos obrigátorios não preenchidos']);
}

$name = strip_tags($_POST['name']);
$phone = strip_tags($_POST['phone']);
$email = strip_tags($_POST['email']);
$message = strip_tags($_POST['message']);

$body = "
<p><strong>Nome:&nbsp;</strong> <br />{$name}</p>
<p><strong>Telefone | WhatsApp:</strong> <br />{$phone}</p>
<p><strong>E-mail:</strong> <br />{$email}<br /><br /><strong>Mesangem:&nbsp;</strong><br />{$message}<br /><br /><br />Mensagem enviada atrav&eacute;s do formul&aacute;rio de contato do site.</p>
";

// Instância da classe
$mail = new PHPMailer(true);
try {
    // Configurações do servidor
    $mail->isSMTP();        //Devine o uso de SMTP no envio
    $mail->SMTPAuth = true; //Habilita a autenticação SMTP
    $mail->Username   = '';
    $mail->Password   = '';
    // Criptografia do envio SSL também é aceito
    $mail->SMTPSecure = 'ssl';
    // Informações específicadas pelo Google
    $mail->Host = '';
    $mail->Port = 465;
    // Define o remetente
    $mail->setFrom($email, $name);
    // Define o destinatário
    $mail->addAddress('noreply@domain.com', $name);
    // Conteúdo da mensagem
    $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    $mail->Subject = utf8_decode('Quero receber mais informações');
    $mail->Body    = $body;
    // Enviar
    $mail->send();
    echo json_encode(['status' => true]);
} catch (Exception $e) {
    echo json_encode(['status' => false, 'message' => $mail->ErrorInfo]);
}
