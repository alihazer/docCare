<?php

require_once '../controllers/appointmentController.php';
require_once '../controllers/doctorsController.php';
require_once '../controllers/patientsController.php';

use Controllers\AppointmentsController;
use Controllers\DoctorsController;
use Controllers\PatientsController;

session_start();

$appointmentsController = new AppointmentsController();
$doctorsController = new DoctorsController();
$patientsModel = new PatientsController();

$patients = $patientsModel->index();
$doctor_id = $_SESSION['id'];
$doctor = $doctorsController->show($doctor_id);
$appointments = $appointmentsController->index();

if (isset($_POST['addAppointment'])) {
    $data = [
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'doctor_id' => $_POST['doctor_id'],
        'patient_id' => $_POST['patient_id']
    ];
    $response = $appointmentsController->add($data);
    if ($response['status'] == 'success') {
        $_SESSION['true'] = $response['message'];
    } else {
        $_SESSION['error'] = $response['message'];
    }
    header("Location: /doc_care/appointments/add");
}



?>

<?php include '../public/components/headTags.php'; ?>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>
    <div class="container">
        <div class="bb">
            <h1>Add Appointment</h1>
            <a href="/doc_care/appointments"><button class="btn btn-primary">View Appointments</button></a>
            <br>
            <br>
            <form method="POST">
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="mb-3">
                    <label for="doctor" class="form-label">Doctor</label>
                    <select name="doctor_id" id="doctor" class="form-select">
                        <?php

                        if (isset($doctor)) {
                            echo "<option style='color: black;' value='" . $doctor['id'] . "'>" . $doctor['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="patient" class="form-label">Patient</label>
                    <select name="patient_id" id="patient" class="form-select">
                        <?php foreach ($patients as $patient) : ?>
                            <option style='color: black;' value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control"></textarea>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary" name="addAppointment">Add Appointment</button>
                </center>
            </form>
            <?php if (isset($_SESSION['error'])) : ?>

                <div class="alert alert-danger" role="alert" style="width: 100%;">
                    <p style="color: red;"> <?php echo $error ?> </p>
                </div>
            <?php endif; ?>
            <!-- Success messages -->
            <?php if (isset($_SESSION['true'])) : ?>
                <br>
                <div class="alert alert-success" role="alert" style="width: 100%;">

                    <h6> <?php echo $_SESSION['true'] ?> </h6>
                </div>
            <?php endif; ?>
        </div>

    </div>
    </div>
    <script src="../public/js/index.js"></script>
</body>

</html>