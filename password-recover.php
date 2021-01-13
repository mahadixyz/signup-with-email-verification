<?php
    if(isset($_POST['pass-recover']))
    {
        require_once 'class/Registration.php';
        $recoverPass = new Registration;
    
        // Check if Sign-up button is pressed   
            $email = $_POST['email'];

            $result = $recoverPass->retriveUserData($email);
          
            if($result != false)
            {
                $subject = "Recover Password";

                foreach($result as $data)
                {
                    $token = $data->token; 
                }

                // Write Email
                $mailBody = 
                "Hello <strong> $fname</strong>, <br>
                Welcome to [Companyname]. <br>
                To reset your password, please Click the button bellow. <br>
                <a style='padding: 5px 34px; background: green; color: white; border: none; width: 150px; height: 50px; display: block; line-height: 50px; text-decoration: none;' href='http://localhost/mahadi/signup-with-email-verification/reset-pass.php?email=$email&token=$token'>Change Password</a><br>
                If the lnk doesn't work, copy and paste the link on your browser.<br>
                http://localhost/mahadi/signup-with-email-verification/reset-pass.php?email=$email&token=$token
                ";
        
                $mailStatus = $recoverPass->sendMail($email, $subject, $mailBody);
                if($mailStatus == false)
                {
                    $_SESSION['error'] = $_SESSION['MailError'];
                }
                else
                {
                    $_SESSION['success'] = "We have send you a link to change your password. Please check your email inbox.";
                }

            }
            else
            {
                $_SESSION['error'] = "No account exist for this Email.";
            }
            
    }
    
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Recover Password</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav" aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNav">

                <ul class="navbar-nav ms-auto me-2 mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Sign in</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign up</a>
                    </li>                    
                   
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-6 mx-auto mt-5 p-5 broder">
                <h2 class="display-4 text-primary text-center">Request Password Change</h2>
                <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    } else if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                ?>
                <form action="password-recover.php" method="POST">

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control rounded-0" placeholder="name@example.com" id="email-field">
                    </div>

                    <button type="submit" name="pass-recover" class="btn btn-primary rounded-0">Request Password Change</button>
                    
                </form>

            </div>
        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>