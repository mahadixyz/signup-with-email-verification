<?php

    require_once 'class/Registration.php';
    $reset = new Registration;

    if(isset($_GET['email'], $_GET['token']))
    {
        $_SESSION['email'] = $_GET['email'];
        $_SESSION['token'] = $_GET['token'];
    }
    
    if(isset($_SESSION['email'], $_SESSION['token']))
    {
        $email = $_SESSION['email'];
        $token = $_SESSION['token'];

        $status = $reset->checkMailToken($email, $token);
        if($status != false)
        {
            if(isset($_POST['pass-reset']))
            {
                $pass = $_POST['password'];
                $cpass = $_POST['cPassword'];
                if($pass === $cpass)
                {
                    $password = password_hash($pass, PASSWORD_DEFAULT);
                    $status = $reset->resetPass($email, $password, $token);
                    if($status != false)
                    {
                        $_SESSION['success'] = 'Password changed. Please Log in with new password <a href="index.php" class="alert-link">login</a> now';
                    }
                    else
                    {
                        $_SESSION['error'] = $_SESSION['err'];
                        unset($_SESSION['err']);
                    }
                }
                else
                {
                    $_SESSION['error'] = "Password doesn't match";
                }
            }           
        }
        else
        {
            $_SESSION['error'] = "Invalid Email/Token.";
        }
    }
    else
    {
        header("Location: signup.php");
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

    <title>Change Password</title>
</head>

<body>   

    <div class="container">
        <div class="row">

            <div class="col-6 mx-auto mt-5 p-5 broder">
            <?php
                if (isset($_SESSION['success'])) 
                {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
                else if (isset($_SESSION['error'])) 
                {
                    echo '<div class="alert alert-danger">' .$_SESSION['error'].'</div>';
                    unset($_SESSION['error']);
                }
            ?>
            <form action="reset-pass.php" method="POST">

                <div class="mb-3">
                    <label for="password-field" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control rounded-0" placeholder="********" id="password-field">
                </div>

                <div class="mb-3">
                    <label for="cPassword-field" class="form-label">Confirm New Password</label>
                    <input type="password" name="cPassword" class="form-control rounded-0" placeholder="********" id="cPassword-field">
                </div>

                <button type="submit" name="pass-reset" class="btn btn-primary rounded-0">Reset Password</button>

            </form>

            </div>

        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>