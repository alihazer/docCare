<?php

include_once '../controllers/patientsController.php';
include_once '../controllers/appointmentController.php';
include_once '../controllers/doctorsController.php';
include_once '../controllers/patient_doctorController.php';


session_start();

use Controllers\PatientsController;
use Controllers\AppointmentsController;
use Controllers\DoctorsController;
use Controllers\PatientDoctorController;



$patientsController = new PatientsController();
$appointmentsController = new AppointmentsController();
$doctorsController = new DoctorsController();
$patientDoctorController = new PatientDoctorController();


if (!isset($_GET['id'])) {
    header('Location: /doc_care/patients');
}

$appointments = $appointmentsController->index('patient_id = ' . $_GET['id']);
// Sort appointments by date
usort($appointments, function ($a, $b) {
    return strtotime($a['appointment_date']) - strtotime($b['appointment_date']);
});
$patient = $patientsController->show($_GET['id']);
if (isset($_POST['deletePatient'])) {
    $response = $patientsController->delete($_GET['id']);
    if ($response['status'] == 'success') {
        $_SESSION['true'] = $response['message'];
    } else {
        $_SESSION['error'] = $response['message'];
    }
    header("Location: /doc_care/patients");
}

$doctors_visited = $patientDoctorController->all('patient_id = ' . $_GET['id']);

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
    <title>Patient Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Patient Profile</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient['name']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $patient['phone_nb']; ?>" disabled>
                    </div>
                    <!-- DOB -->
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $patient['dob']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <!-- Total nb of appointments -->
                        <label for="appointments">Total number of appointments</label>
                        <input type="text" class="form-control" id="appointments" name="appointments" value="<?php echo count($appointments); ?>" disabled>
                    </div>
                    <!-- Total nb of doctors visited -->
                    <div class="form-group">
                        <label for="doctors">Total number of doctors visited</label>
                        <input type="text" class="form-control" id="doctors" name="doctors" value="<?php echo count($doctors_visited); ?>" disabled>
                    </div>
                    <br>
                    <center>
                        <button type="submit" class="btn btn-danger" name="deletePatient">Delete</button>
                    </center>
                </form>
            </div>
        </div>

        <!-- Old Appointments -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h1>Old Appointments</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $key => $appointment) : ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; ?></th>
                                <td><?php echo $appointment['appointment_date']; ?></td>
                                <td><?php echo $appointment['appointment_time']; ?></td>
                                <td><?php echo $appointment['status']; ?></td>
                                <td><?php echo $doctorsController->show($appointment['doctor_id'])['name'] ?></td>
                                <td>
                                    <a href="/doc_care/appointments/view/<?php echo $appointment['id']; ?>">
                                        <button class="btn btn-primary">View</button>
                                    </a>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
</body>

</html>