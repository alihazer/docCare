<?php

require_once '../controllers/medicalRecordController.php';
require_once '../controllers/patientsController.php';

use Controllers\MedicalRecordController as MedicalRecordController;
use Controllers\PatientsController as PatientsController;

$medicalRecordController = new MedicalRecordController();
$patientsController = new PatientsController();

$patients = $patientsController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'patient_id' => $_POST['patient_id'],
        'date' => $_POST['date'],
        'diagnosis' => $_POST['diagnosis'],
        'treatment' => $_POST['treatment'],
        'medication' => $_POST['medication'],
        'notes' => $_POST['notes']
    ];
    $result = $medicalRecordController->add($data);
    if ($result) {
        header('Location: /medicalRecords');
    }
}
?>

<?php include '../public/components/headTags.php'; ?>

<body>
    <div class="container">
        <h1>Add Medical Record</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="patient_id">Patient</label>
                <select name="patient_id" id="patient_id">
                    <?php foreach ($patients as $patient) : ?>
                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="diagnoses">
                <input type="text" name="treatment">
                <input type="text" name="medication">
                <input type="text" name="notes">

                <button type="submit">Add</button>

            </div>
</body>

</html>