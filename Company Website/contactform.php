<?php
// Include the Composer autoloader for PHPMailer
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);
    $userEmail = htmlspecialchars($_POST["email"]);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->SMTPSecure = 'tls'; // Use TLS encryption
        $mail->Port = 587; // SMTP port for TLS

        // Disable certificate verification
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // Set your Gmail credentials
        $mail->Username = 'your@gmail.com'; // Your Gmail email address
        $mail->Password = 'your_password'; // Your Gmail password

        // Set sender and recipient
        $mail->setFrom($userEmail, $name);
        $mail->addAddress('webdrivesuprt@gmail.com');
        // Set email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "Name: $name<br>Subject: $subject<br>Message: $message";

        // Send the email
        if ($mail->send()) {
            // Email sent successfully
            header("Location: response.html");
            exit;
        } else {
            // Redirect to error page
            header("Location: error.html");
            exit;
        }
    } catch (Exception $e) {
        echo 'An error occurred: ' . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
