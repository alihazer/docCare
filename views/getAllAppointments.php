<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /doc_care/login');
}

require_once '../controllers/appointmentController.php';
require_once '../controllers/patientsController.php';
require_once '../controllers/doctorsController.php';

use Controllers\AppointmentsController as AppointmentsController;
use Controllers\PatientsController as PatientsController;
use Controllers\DoctorsController as DoctorsController;

$appointmentsController = new AppointmentsController();
$patientsController = new PatientsController();
$doctorsController = new DoctorsController();

$doctor_id = $_SESSION['id'];

$appointments = $appointmentsController->index('doctor_id = ' . $doctor_id . ' AND status = "pending"');
$allAppointments = $appointmentsController->index();
$your_end_appointments = $appointmentsController->index('doctor_id = ' . $doctor_id . ' AND status = "ended"');

// Sort appointments by date
usort($appointments, function ($a, $b) {
    return strtotime($a['appointment_date']) - strtotime($b['appointment_date']);
});



if (isset($_SESSION['true'])) {
    unset($_SESSION['true']);
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

if (isset($_SESSION['response'])) {
    unset($_SESSION['response']);
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
    <?php include '../public/components/header.php';

    ?>
    <center>
        <div style="width: 90%;">
            <div>
                <br><br>
                <center>
                    <h1>Your Appointments</h1>
                    <a href="/doc_care/appointments/add"><button class="btn btn-primary">Add Appointment</button></a>
                    <br>
                    <br>
                </center>
                <div class="table-responsive" style="padding: 0 15px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Status</th>
                                <th scope="col">Doctor</th>
                            </tr>
                        </thead>
                        <?php
                        if (count($appointments) == 0) {
                            echo '<tr>';
                            echo '<td colspan="7">No appointments found</td>';
                            echo '</tr>';
                        } else {


                            foreach ($appointments as $appointment) {
                                $patient = $patientsController->show($appointment['patient_id']);
                                $doctor_id = $appointment['doctor_id'];
                                $doctor = $doctorsController->show($doctor_id);
                                echo '<tr>';
                                echo '<td>' . $appointment['id'] . '</td>';
                                echo '<td>' . $patient['name'] . '</td>';
                                echo '<td>' . $appointment['appointment_date'] . '</td>';
                                echo '<td>' . $appointment['appointment_time'] . '</td>';
                                echo '<td>' . $appointment['notes'] . '</td>';
                                if ($appointment['status'] == 'pending') {
                                    echo '<td>' . $appointment['status'] .
                                        '<form method="post" action="/doc_care/appointments/view/' . $appointment['id'] . '">
                            <button type="submit" class="btn btn-success" >Start</button>
                        </form>                    </td>';
                                } else {
                                    echo '<td>' . $appointment['status'] .  '<a> <button class="btn btn-success">End</button> </a>  </td>';
                                }
                                echo '<td>' . $doctor['name'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
                <br><br>
                <center>
                    <h1>Your Ended Appointments</h1>
                </center>
                <div class="table-responsive" style="padding: 0 15px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Status</th>
                                <th scope="col">Doctor</th>
                            </tr>
                        </thead>
                        <?php
                        if (count($your_end_appointments) == 0) {
                            echo '<tr><td colspan="7">No appointments found</td></tr>';
                        } else {
                            foreach ($your_end_appointments as $appointment) {
                                $patient = $patientsController->show($appointment['patient_id']);
                                $doctor_id = $appointment['doctor_id'];
                                $doctor = $doctorsController->show($doctor_id);
                                echo '<tr>';
                                echo '<td><form action="/doc_care/appointments/view/' . $appointment['id'] . '" method="POST"><button class="btn btn-primary" style="color:black;border:none" type="submit">' . $appointment['id'] . '</button></form></td>';
                                echo '<td>' . $patient['name'] . '</td>';
                                echo '<td>' . $appointment['appointment_date'] . '</td>';
                                echo '<td>' . $appointment['appointment_time'] . '</td>';
                                echo '<td>' . $appointment['notes'] . '</td>';
                                echo '<td>' . $appointment['status'] . '</td>';
                                echo '<td>' . $doctor['name'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
                <br><br>

                <center>
                    <h1>All Appointments</h1>
                </center>
                <div class="table-responsive" style=" padding: 0 15px;">
                    <table class=" table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Status</th>
                                <th>Doctor</th>
                            </tr>
                        </thead>
                        <?php
                        if (count($allAppointments) == 0) {
                            echo '<tr><td colspan="7">No appointments found</td></tr>';
                        } else {
                            // Display all appointments (for all doctors)
                            foreach ($allAppointments as $appointment) {
                                $patient = $patientsController->show($appointment['patient_id']);
                                $doctor_id = $appointment['doctor_id'];
                                $doctor = $doctorsController->show($doctor_id);
                                echo '<tr>';
                                echo '<td>' . $appointment['id'] . '</td>';
                                echo '<td>' . $patient['name'] . '</td>';
                                echo '<td>' . $appointment['appointment_date'] . '</td>';
                                echo '<td>' . $appointment['appointment_time'] . '</td>';
                                echo '<td>' . $appointment['notes'] . '</td>';
                                echo '<td>' . $appointment['status'] . '</td>';
                                echo '<td>' . $doctor['name'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </center>
    <script src="public/js/index.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>