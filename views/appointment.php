<?php

require_once '../controllers/appointmentController.php';
require_once '../controllers/DoctorsController.php';
require_once '../controllers/PatientsController.php';
require_once '../controllers/medicalRecordController.php';
session_start();

use Controllers\AppointmentsController;
use Controllers\DoctorsController;
use Controllers\PatientsController;
use Controllers\MedicalRecordController;

$appointmentsController = new AppointmentsController();
$doctorsController = new DoctorsController();
$patientsController = new PatientsController();
$medicalRecordsController = new MedicalRecordController();


if (!isset($_GET['id'])) {
    header('Location: /doc_care/appointments');
}
$appointment_id = $_GET['id'];
$url = "/doc_care/appointments/start/" . $appointment_id;
$appointment = $appointmentsController->show($appointment_id);
$patient = $patientsController->show($appointment['patient_id']);
$doctor_id = $appointment['doctor_id'];
$doctor = $doctorsController->show($doctor_id);


if (isset($_POST['start_appointment'])) {
    $appointment_new = $appointmentsController->changeStatus($appointment_id, 'in_progress');
    // Create a medical record for this appointment
    header("Location: /doc_care/appointments/view/" . $appointment_id);
}

if (isset($_POST['end_appointment'])) {
    $data = [
        'diagnoses' => $_POST['diagnosis'],
        'treatment' => $_POST['treatment'],
        'medication' => $_POST['medication'],
        'notes' => $_POST['notes'],
        'appointment_id' => $appointment_id
    ];
    $medicalRecordsController->add($data);
    $appointmentsController->changeStatus($appointment_id, 'ended');
    header("Location: /doc_care/home");
}

if ($appointment['status'] == 'ended') {
    $medicalRecord = $medicalRecordsController->show(1, "*", 'appointment_id = ' . $appointment_id);
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
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>
    <div class="container-md">
        <center>
            <div class="aa">
                <h1>Details:</h1>
            </div>
        </center>
        <br>
        <div class="bb" style="display: flex; align-items:center; justify-content:center; width:100%; flex-direction:column">
            <div style="width: 100%;display: flex; align-items:center; justify-content:center;">
                <div style="width: 100%;display: flex; align-items:center; justify-content:center; flex-direction:column">
                    <h3>Patient Details</h3>
                    <p><strong>Name:</strong> <?php echo $patient['name'] ?></p>
                    <p><strong>Date Of Birth:</strong> <?php echo $patient['dob'] ?></p>
                    <p><strong>Phone:</strong> <?php echo $patient['phone_nb'] ?></p>
                    <p><strong>Medical History:</strong> <?php echo $patient['medical_history'] ?></p>
                </div>
                <div style="width: 100%;display: flex; align-items:center; justify-content:center; flex-direction:column">
                    <h3>Appointment Details</h3>
                    <p><strong>Date:</strong> <?php echo $appointment['appointment_date'] ?></p>
                    <p><strong>Time:</strong> <?php echo $appointment['appointment_time'] ?></p>
                    <p><strong>Status:</strong> <?php echo $appointment['status'] ?></p>
                    <p><strong>Doctor:</strong> <?php echo $doctor['name'] ?></p>
                </div>
            </div>
            <br>
            <!-- Add Medical Record -->
            <?php if ($appointment['status'] == 'pending') : ?>
                <div class="a" role="alert">
                    <form action="/doc_care/appointments/view/<?php echo $appointment['id']; ?>" method="POST">
                        <button class="btn btn-primary" style="color:black;border:none" name="start_appointment" type="submit"> Start appointment </button>
                    </form>
                </div>
            <?php elseif ($appointment['status'] == 'in_progress') : ?>
                <div class="dd" style="width: 100%;display: flex; align-items:center; justify-content:center; flex-direction:column;">
                    <h3>Medical Record</h3>
                    <form method="POST" style="width: 70%;">
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <input type="text" class="form-control" id="diagnosis" name="diagnosis" required>
                        </div>
                        <div class="mb-3">
                            <label for="treatment" class="form-label">Treatment</label>
                            <input type="text" class="form-control" id="treatment" name="treatment" required>
                        </div>
                        <div class="mb-3">
                            <label for="medication" class="form-label">Medication</label>
                            <input type="text" class="form-control" id="medication" name="medication" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary" name="end_appointment">End Appointment</button>
                        </center>
                    </form>
                </div>
            <?php elseif ($appointment['status'] == 'pending') : ?>
                <center>
                    <form method="post">
                        <button type="submit" class="btn btn-success" name="start_appointment">Start Appointment</button>
                    </form>
                </center>

            <?php elseif ($appointment['status'] == 'ended') : ?>
                <center>
                    <!-- Get medical record for this appointment -->
                    <?php if (!empty($medicalRecord)) : ?>
                        <?php $record = $medicalRecord[0]; ?> <!-- Access the inner array -->
                        <div class="dd" style="width: 100%;display: flex; align-items:center; justify-content:center; flex-direction:column;">
                            <h3>Medical Record</h3>
                            <p><strong>Diagnosis:</strong> <?php echo $record['diagnoses'] ?></p>
                            <p><strong>Treatment:</strong> <?php echo $record['treatment'] ?></p>
                            <p><strong>Medication:</strong> <?php echo $record['medication'] ?></p>
                            <p><strong>Notes:</strong> <?php echo $record['notes'] ?></p>
                        </div>
                    <?php else : ?>
                        <p>No medical record found.</p>
                    <?php endif; ?>

                    <div class="alert alert-danger" role="alert" style="width: 100%;">
                        <h6 style="color: red;">This appointment has already ended</h6>
                    </div>
                </center>

                <center>
                <?php endif; ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="public/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>