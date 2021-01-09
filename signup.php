<?php
    session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Homepage</title>
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
                        <a class="nav-link" href="index.php">Sign in</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="signup.php">Sign up</a>
                    </li>                    
                   
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-6 mx-auto mt-5 p-5 broder">
                <h2 class="display-4 text-primary text-center">Sign up</h2>
                <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        session_destroy();
                    } else if (isset($_SESSION['err'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['err'] . '</div>';
                        session_destroy();
                    }
                ?>
                <form action="action.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="full-name-field" class="form-label">Full name</label>
                        <input type="text" name="fname" class="form-control rounded-0" placeholder="John Doe" id="full-name-field" required>
                    </div>

                    <div class="mb-3">
                        <label for="email-field" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control rounded-0" placeholder="name@example.com" id="email-field" required>
                    </div>

                    <div class="mb-3">
                        <label for="password-field" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control rounded-0" placeholder="********" id="password-field" required>
                    </div>

                    <button type="submit" name="signup-btn" class="btn btn-primary rounded-0">Signin</button>

                    <a href="index.php" class="btn btn-outline-success rounded-0">Already have a account? Sign in</a>
                </form>

            </div>
        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>