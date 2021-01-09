<?php

    require_once 'class/Registration.php';
    $dbaction = new Registration;

    if(isset($_POST['signup-btn']))
    {
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $password =  password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = md5(uniqid(rand()));
        $dbaction->register($fname, $email, $password, $token);
        header('Location: signup.php');

    }


    if(isset($_POST['recipient']))
    {
        
        require_once 'class/class.phpmailer.php';
        require_once 'class/class.smtp.php';

        $mail = new PHPMailer;

        // Email address from user input
        $recipient = $_POST['recipient'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'yourmail@email.com';                 // SMTP username
        $mail->Password = 'your-password-of-email';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('yourmail@email.com', 'Your Name/Brand Name');
        $mail->addAddress($recipient);               // Add recipient
        $mail->addReplyTo('yourmail@email.com', 'Your Name/Brand Name');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;

        //If email send fail, show error message, otherwise show success message (through SESSION)
        if(!$mail->send()) 
        {
            $_SESSION['error'] = 'Message could not be sent.  Error: ' . $mail->ErrorInfo;
            header('Location: index.php');
        } 
        else 
        {
            $_SESSION['success'] = 'Message is sent.';
            header('Location: index.php');
        }
        
    }
    else
    {

    }

    

?>