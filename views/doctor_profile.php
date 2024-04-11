<?php
include_once '../controllers/doctorsController.php';
include_once '../controllers/appointmentController.php';
include_once '../controllers/patientsController.php';
include_once '../controllers/patient_doctorController.php';

session_start();

use Controllers\DoctorsController;
use Controllers\AppointmentsController;
use Controllers\PatientsController;
use Controllers\PatientDoctorController;

$doctorsController = new DoctorsController();
$appointmentsController = new AppointmentsController();
$patientsController = new PatientsController();
$patientDoctorController = new PatientDoctorController();


if (!isset($_GET['id'])) {
    header('Location: /doc_care/patients');
}

$doctor = $doctorsController->show($_GET['id']);
$appointments = $appointmentsController->index('doctor_id = ' . $_GET['id']);
$patients = $patientDoctorController->all('doctor_id = ' . $_GET['id']);

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
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>

    <!-- Doctor Profile -->
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="z-index: -1;">
                <h1>Doctor Profile</h1>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $doctor['name'] ?></h5>
                        <h5 class="card-text">Email: <?php echo $doctor['email'] ?></h5>
                        <h5 class="card-text">Specialization: <?php echo $doctor['major'] ?></h5>
                        <h5 class="card-text">Degree: <?php echo $doctor['degree'] ?></h5>
                        <h5 class="card-text">Working Hours: <?php echo $doctor['working_hours'] ?></h5>
                        <h5 class="card-text">Starting Hour: <?php echo $doctor['starting_hour'] ?></h5>
                        <h5 class="card-text">Ending Hour: <?php echo $doctor['ending_hour'] ?></h5>
                        <!-- Total nb of appointments: -->
                        <h5 class="card-text">Total number of appointments: <?php echo count($appointments) ?></h5>
                        <!-- Total nb of patients: -->
                        <h5 class="card-text">Total number of patients: <?php echo count($patients) ?></h5>
                        <a href="/doc_care/doctors" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/js/index.js"></script>
</body>