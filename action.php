<?php

    require_once 'class/Registration.php';
    $dbaction = new Registration;

    // Check if Sign-up button is pressed
    if(isset($_POST['signup-btn']))
    {
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $password =  password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = md5(uniqid(rand()));
        $subject = "Activate Your Account";

        // Write Email
        // $mailBody = 
        // "Hello <strong> $fname</strong>, <br>
        // Welcome to [Companyname]. <br>
        // To activate your user account, please Click the button bellow. <br>
        // <a style='padding: 5px 34px; background: green; color: white; border: none; width: 150px; height: 50px; display: block; line-height: 50px; text-decoration: none;' href='http://localhost/mahadi/signup-with-email-verification/activate.php?email=$email&token=$token'>Click here to activate</a><br>
        // If the lnk doesn't work, copy and paste the link on your browser.<br>
        // http://localhost/mahadi/signup-with-email-verification/activate.php?email=$email&token=$token
        // ";

        $mailBody = 
        "Hello <strong> $fname</strong>, <br>
        Welcome to [Companyname]. <br>
        To activate your user account, please Click the button bellow. <br>
        <a style='padding: 5px 34px; background: green; color: white; border: none; width: 150px; height: 50px; display: block; line-height: 50px; text-decoration: none;' href='http://localhost/signup-with-email-verification/activate.php?email=$email&token=$token'>Click here to activate</a><br>
        If the lnk doesn't work, copy and paste the link on your browser.<br>
        http://localhost/signup-with-email-verification/activate.php?email=$email&token=$token
        ";

        $dbaction->register($fname, $email, $password, $token, $subject, $mailBody);
        header('Location: signup.php');
    }
    else if(isset($_POST['signin-btn'])) // Check if Sign in Button is pressed
    {       
        $email = $_POST['email'];
        $password = $_POST['password'];

        $status = $dbaction->signin($email, $password);
        if($status == true)
        {
            header('Location: dashboard.php');
        }
        else
        {
            header('Location: index.php');
        }
        

    }        
    else
    {
        // if someone tried to access directly via URL, redirect to the login page
        header('Location: index.php');
    }
    
    

?>