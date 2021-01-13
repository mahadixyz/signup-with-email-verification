<?php
    require_once 'class/Registration.php';
    $dashboard = new Registration;

    if(!isset($_SESSION['user_id']))
    {
        header('Location: index.php');
    }

    $result = $dashboard->viewData($_SESSION['user_id']);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Dashboard</title>
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
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="sign-out.php">Sign out</a>
                    </li>                    
                   
                </ul>
                
            </div>
        </div>
    </nav>

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
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
               
                    if($result != false)
                    {
                        foreach($result as $data)
                        { 
                                                              
                            
                ?>
                    <div class="border p-5">
                            <h3 class="text-center">Welcome, <?=$data->user_fullname?> </h3>
                            <a class="btn btn-danger d-grid mx-auto rounded-0 mt-5" href="sign-out.php">Sign out</a>
                    </div>
                <?php                                                            
                        }
                    }
                ?>

            </div>

        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>