<?php

use Controllers\DoctorsController as DoctorsController;

require_once '../controllers/doctorsController.php';
session_start();
if (isset($_POST['registerDoctor'])) {
    // Validations
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['major']) || empty($_POST['degree']) || empty($_POST['working_hours']) || empty($_POST['starting_hour']) || empty($_POST['ending_hour'])) {
        $_SESSION['error'] = 'Please fill all the fields';
        header('Location: /doc_care/register');
        return;
    }

    if (empty($_POST['available_days'])) {
        $_SESSION['error'] = 'Please select at least one day';
        header('Location: /doc_care/register');
        return;
    }
    if ($_POST['working_hours'] < 1 || $_POST['working_hours'] > 24) {
        $_SESSION['error'] = 'Working hours should be between 1 and 24';
        header('Location: /doc_care/register');
        return;
    }
    if ($_POST['starting_hour'] >= $_POST['ending_hour']) {
        $_SESSION['error'] = 'Starting hour should be less than ending hour';
        header('Location: /doc_care/register');
        return;
    }
    if ($_POST['ending_hour'] <= $_POST['starting_hour']) {
        $_SESSION['error'] = 'Ending hour should be greater than starting hour';
        header('Location: /doc_care/register');
        return;
    }
    $doctorsController = new DoctorsController();
    $result = $doctorsController->add();
}

if (isset($result['status']) && $result['status'] == 'success') {
    $_SESSION['message'] = $result['message'];
    header('Location: /doc_care/login');
    return;
}

if (isset($result['status']) && $result['status'] == 'error') {
    $_SESSION['error'] = $result['message'];
    header('Location: /doc_care/register');
    return;
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
        <!-- Error messages -->
        <?php if (isset($_SESSION['error'])) : ?>
            <?php if (isset($_SESSION['message'])) {
                unset($_SESSION['message']);
            } ?>
            <div class="alert alert-danger" role="alert" style="width: 40%; height: 50px;">
                <p style="color: red;"> <?php echo $_SESSION['error'] ?> </p>
            </div>
        <?php endif; ?>
        <!-- Success messages -->
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <h1> <?php $_SESSION['message'] ?> </h1>
            </div>

        <?php endif; ?>

        <div class="row">
            <!-- Add some margin left -->
            <div class="col-md-12" style="align-items:center; display:flex; justify-content:center;flex-direction:column">
                <img style="width:50%" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiTUKnC6ox5v-snyVif-fuzhLn6NEiphu_tKaI64y8wkwdur_vZokaHC-cObT2e7r3UZMmXBmMk0LkZw9cTUhuHG4pJNok6qdijlTtUhwq04SYQkhaAcbioHEAJRggDQLkQpwv4096VgQu8jzo5N075LYCxj38mLpfWpny_ZtBXX1_MmqFGH9i4brAabQE/s600/%5Bremoval.ai%5D_f24120a2-2c59-4feb-8e8a-dd09dcae6477-screenshot-2024-04-09-230712.png" alt="">
            </div>
            <div class="col-md-6" style="align-items:center; display:flex; justify-content:center;flex-direction:column; width:100%">
                <h1 class="text-center" id="w-msg">Doctor Registration</h1>
                <br>
                <form action="/doc_care/register" method="post" style="width: 50%;">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="input-group mb-3">
                        <div style="margin-right: 10px;">
                            <label for="major">Major</label>
                        </div>

                        <select class="custom-select" id="major" name="major" style="color: black; width:100%; height:40px; border-radius:10px">
                            <option style="color: black;" selected>Choose...</option>
                            <option style="color: black;" value="Cardiology">Cardiology</option>
                            <option style="color: black;" value="Pediatrics">Pediatrics</option>
                            <option style="color: black;" value="Neurology">Neurology</option>
                            <option style="color: black;" value="Orthopedics">Orthopedics</option>
                            <option style="color: black;" value="Oncology">Oncology</option>
                            <option style="color: black;" value="Dermatology">Dermatology</option>
                            <option style="color: black;" value="Gynecology">Gynecology</option>
                            <option style="color: black;" value="Urology">Urology</option>
                            <option style="color: black;" value="Ophthalmology">Ophthalmology</option>
                            <option style="color: black;" value="Psychiatry">Psychiatry</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="degree" class="form-label">Degree</label>
                        <input type="text" class="form-control" id="degree" name="degree" required>
                    </div>
                    <div class="mb-3">
                        <label for="available_days" class="form-label">Available Days</label><br>
                        <center>
                            <div class="days" style="display:flex; align-items:center;justify-content:center; width:70%; flex-wrap:wrap; flex-direction: column">
                                <div class="day">
                                    <input type="checkbox" id="monday" name="days" value="monday">
                                    <label for="monday">Monday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="tuesday" name="days" value="tuesday">
                                    <label for="tuesday">Tuesday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="wednesday" name="days" value="wednesday">
                                    <label for="wednesday">Wednesday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="thursday" name="days" value="thursday">
                                    <label for="thursday">Thursday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="friday" name="days" value="friday">
                                    <label for="friday">Friday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="saturday" name="days" value="saturday">
                                    <label for="saturday">Saturday</label>
                                </div>
                                <div class="day">
                                    <input type="checkbox" id="sunday" name="days" value="sunday">
                                    <label for="sunday">Sunday</label>
                                </div>
                                <input type="hidden" name="available_days" value="">
                            </div>
                        </center>
                    </div>
                    <div class="mb-3">
                        <label for="working_hours" class="form-label">Total Working Hours /day</label>
                        <input type="number" class="form-control" id="working_hours" name="working_hours" required>
                    </div>
                    <div class="mb-3">
                        <label for="starting_hour" class="form-label">Starting Hour</label>
                        <input type="time" class="form-control" id="starting_hour" name="starting_hour" required>
                    </div>

                    <div class="mb-3">
                        <label for="ending_hour" class="form-label">Ending Hour</label>
                        <input type="time" class="form-control" id="ending_hour" name="ending_hour" required>
                    </div>
            </div>

            <center>
                <button type="submit" class="btn btn-primary" name="registerDoctor">Register</button>
            </center>
            </form>
        </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="public/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>

</html>