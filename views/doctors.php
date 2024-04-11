<?php

include_once '../controllers/doctorsController.php';

session_start();

use Controllers\DoctorsController;

$doctorsController = new DoctorsController();

$doctors = $doctorsController->index();
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
    <style>
        .table-responsive {
            overflow-x: auto;
            display: block;
            width: 100%;
        }

        .table {
            width: max-content;
        }
    </style>
</head>

<body>
    <!-- Include the header component -->
    <?php include '../public/components/header.php'; ?>
    <center>
        <div style="width: 100%;">
            <center>
                <h1>Doctors</h1>
                <div class="d">
                    <a href="/doc_care/register" class="btn btn-primary">Add Doctor</a>
                </div>
            </center>
            <br>
            <div class="table-responsive" style="padding: 0 15px;">
                <table class="table" style="width: 90%;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Major</th>
                            <th scope="col">Degree</th>
                            <th scope="col">Available Days</th>
                            <th scope="col">Working Hours</th>
                            <th scope="col">Starting Hour</th>
                            <th scope="col">Ending Hour</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>

                    <?php foreach ($doctors as $doctor) : ?>
                        <tr class="<?php echo ($doctor['id'] == $_SESSION['id']) ? 'table-success' : ''; ?>">
                            <td scope="row"><?php echo $doctor['id'] ?></td>
                            <td><?php echo $doctor['name'] ?></td>
                            <td><?php echo $doctor['email'] ?></td>
                            <td><?php echo $doctor['major'] ?></td>
                            <td><?php echo $doctor['degree'] ?></td>
                            <td><?php echo $doctor['available_days'] ?></td>
                            <td><?php echo $doctor['working_hours'] ?></td>
                            <td><?php echo $doctor['starting_hour'] ?></td>
                            <td><?php echo $doctor['ending_hour'] ?></td>
                            <td>
                                <a href="/doc_care/doctors/view/<?php echo $doctor['id'] ?>" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>

    </center>
    <script src="public/js/index.js"></script>
</body>

</html>