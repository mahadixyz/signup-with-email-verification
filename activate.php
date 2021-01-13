<?php

    require_once 'class/Registration.php';
    $activate = new Registration;

    if(isset($_GET['email'], $_GET['token']))
    {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $status = $activate->activate($email, $token);
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

    <title>Activate</title>
</head>

<body>   

    <div class="container">
        <div class="row">

            <div class="col-6 mx-auto mt-5 p-5 broder">
        <?php
            if(isset($_SESSION['err']))
            {
        ?>
                <div class="alert alert-danger">Error: <?=$_SESSION['err']?></div> 
        <?php
                unset($_SESSION['err']);
            }    
            if($status == true)
            {
        ?>
            <div class="alert alert-success p-3">Thank you for verifying your account. You can <a href="index.php" class="alert-link">login</a> now.</div>
        <?php
            }            
        ?>

            </div>

        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>