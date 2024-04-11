<?php

include_once '../controllers/patientsController.php';
include_once '../controllers/doctorsController.php';
include_once '../controllers/patient_doctorController.php';
session_start();

use Controllers\PatientsController;
use Controllers\DoctorsController;
use Controllers\PatientDoctorController;

$patientsController = new PatientsController();
$doctorsController = new DoctorsController();
$patientDoctorController = new PatientDoctorController();
$patients = $patientsController->index();
$doctor_id = $_SESSION['id'];
$your_patients = $patientDoctorController->all('doctor_id = "' . $doctor_id . '"');

$patients = $patientsController->index();
if (isset($_POST['delete_patient'])) {
    $patient_id = $_GET['id'];
    $response = $patientDoctorController->delete($patient_id);
    if ($response['status'] == 'success') {
        $_SESSION['true'] = $response['message'];
    } else {
        $_SESSION['error'] = $response['message'];
    }
    header("Location: /doc_care/appointments/add");
}

if (isset($_POST['logout'])) {
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
    <?php if (isset($_SESSION['error'])) : ?>
        <center>
            <div class="alert alert-danger" role="alert" style="width: 50%;">
                <p style="color: red;"> <?php echo $error ?> </p>
            </div>
        </center>
    <?php endif; ?>
    <!-- Success messages -->
    <?php if (isset($_SESSION['true'])) : ?>
        <br>
        <center>
            <div class="alert alert-success" role="alert" style="width: 50%; z-index:-1;">

                <h6> <?php echo $_SESSION['true'] ?> </h6>
            </div>
        </center>
    <?php endif; ?>
    </div>
    <center>
        <div style="width: 90%;">
            <h1>Your Patients</h1>
            <!-- Add Patient btn -->
            <div><a href="/doc_care/patients/add" class="btn btn-primary">Add Patient</a> </div>
            <br>

            <div class="table-responsive" style="margin:0 15px">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($your_patients as $patient) : ?>
                            <?php $patient = $patientsController->show($patient['patient_id']); ?>
                            <tr>
                                <th scope="row"><?php echo $patient['id']; ?></th>
                                <td><?php echo $patient['name']; ?></td>
                                <td><?php echo $patient['dob']; ?></td>
                                <td><?php echo $patient['phone_nb']; ?></td>
                                <td>
                                    <a href="/doc_care/patients/view/<?php echo $patient['id']; ?>">
                                        <button class="btn btn-danger">Delete</button>
                                    </a>
                                    <a href="/doc_care/patients/view/<?php echo $patient['id']; ?>">
                                        <button class="btn btn-primary">View</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>



            <div class="table-responsive" style="margin: 0 15px;">
                <h1>Patients</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient) : ?>
                            <tr>
                                <th scope="row"><?php echo $patient['id']; ?></th>
                                <td><?php echo $patient['name']; ?></td>
                                <td><?php echo $patient['dob']; ?></td>
                                <td><?php echo $patient['phone_nb']; ?></td>
                                <td>
                                    <a> <button disabled class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </center>
    <script src="public/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-+0n0l4+XVb3pO2Gv8zFZJvZ3j3yJ6J7Zzrj
</body>
</html>