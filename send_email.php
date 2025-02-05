<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide !");
    }

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mainatypicars82@gmail.com'; 
        $mail->Password   = 'Joelatypicars82_';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinataires
        $mail->setFrom($email, $name);
        $mail->addAddress(address: 'mainatypicars82@gmail.com'); // Adresse de réception

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de $name";
        $mail->Body    = "<strong>Nom :</strong> $name<br><strong>Email :</strong> $email<br><strong>Message :</strong><br>$message";

        $mail->send();
        
        // Redirection après envoi
        header("Location: success.html");
        exit();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    }
} else {
    die("Méthode non autorisée.");
}
?>
