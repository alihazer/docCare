<?php
session_start();
if (isset($_POST['addPatient'])) {
    require_once '../controllers/patientsController.php';
    $patientsController = new Controllers\PatientsController();
    $result =  $patientsController->add();

    if (isset($result['status']) && $result['status'] == 'success') {
        $_SESSION['true'] = $result['message'];
    }
    if (isset($result['status']) && $result['status'] == 'error') {
        $_SESSION['error'] = $result['error'];
    }
    header('Location: /doc_care/patients/add');
}
?>

<?php include '../public/components/headTags.php'; ?>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>
    <div class="container">
        <div class="bb">
            <h1>Add Patient</h1>
            <a href="/doc_care/patients"><button class="btn btn-primary">View Patients</button></a>
            <br>
            <br>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
                <div class="mb-3">
                    <label for="phone_nb" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_nb" name="phone_nb" required>
                </div>
                <div class="mb-3">
                    <label for="medical_history" class="form-label">Medical History</label>
                    <textarea class="form-control" id="medical_history" name="medical_history" required></textarea>
                </div>
                <button type="submit" name="addPatient" class="btn btn-primary">Add Patient</button>
            </form>
            <?php if (isset($_SESSION['true'])) : ?>

                <br>
                <div class="alert alert-success" role="alert" style="width: 100%;">

                    <h6> <?php echo $_SESSION['true'] ?> </h6>

                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger" role="alert" style="width: 50%;">
                    <h6 style="color: red;"> <?php echo $_SESSION['error'] ?> </h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>