<?php

use Controllers\DoctorsController;

require_once '../controllers/doctorsController.php';
session_start();
if (isset($_POST['login'])) {
    $doctorsController = new DoctorsController();
    $response = $doctorsController->login($_POST);
    if (isset($response['status'])) {
        $_SESSION['error'] = $response['message'];
        header('Location: /doc_care/login');
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /doc_care/login');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>
    <br>
    <br>
    <div style="overflow-x: hidden;">
        <div class="row">
            <!-- Add some margin left -->
            <div class="col-md-12" style="align-items:center; display:flex; justify-content:center;flex-direction:column">
                <img style="width:50%" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiTUKnC6ox5v-snyVif-fuzhLn6NEiphu_tKaI64y8wkwdur_vZokaHC-cObT2e7r3UZMmXBmMk0LkZw9cTUhuHG4pJNok6qdijlTtUhwq04SYQkhaAcbioHEAJRggDQLkQpwv4096VgQu8jzo5N075LYCxj38mLpfWpny_ZtBXX1_MmqFGH9i4brAabQE/s600/%5Bremoval.ai%5D_f24120a2-2c59-4feb-8e8a-dd09dcae6477-screenshot-2024-04-09-230712.png" alt="">
            </div>
            <div class="col-md-6" style="align-items:center; display:flex; justify-content:center;flex-direction:column; width:100%">
                <h1 class="text-center" id="w-msg">Login</h1>
                <br>
                <form action="/doc_care/login" method="post" style="width: 50%;">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </center>
                </form>
                <br>
                <?php if (isset($_SESSION['message'])) : ?>
                    <?php if (isset($_SESSION['error'])) {
                        unset($_SESSION['error']);
                    } ?>
                    <div class="alert alert-success" role="alert" style="width: 50%;">
                        <h6> <?php echo $_SESSION['message'] ?> </h6>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])) : ?>
                    <?php if (isset($_SESSION['message'])) {
                        unset($_SESSION['message']);
                    } ?>
                    <div class="alert alert-danger" role="alert" style="width: 50%;">
                        <h6 style="color: red;"> <?php echo $_SESSION['error'] ?> </h6>
                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="public/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>