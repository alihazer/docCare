<?php


namespace Controllers;

use Models\DoctorsModel as DoctorsModel;

// path based on the request
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}

require_once ROOT_PATH . '/models/DoctorsModel.php';

class DoctorsController
{
    private $doctorsModel;

    public function __construct()
    {
        $this->doctorsModel = new DoctorsModel();
    }

    public function index()
    {
        $doctors = $this->doctorsModel->all();
        return $doctors;
    }

    public function add()
    {
        session_start();
        unset($_SESSION['error']);
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'major' => $_POST['major'],
            'degree' => $_POST['degree'],
            'available_days' => $_POST['available_days'],
            'working_hours' => $_POST['working_hours'],
            'starting_hour' => $_POST['starting_hour'],
            'ending_hour' => $_POST['ending_hour']
        ];
        $alreadyExists = $this->doctorsModel->getByEmail1($data['email']);

        if ($alreadyExists) {
            return $response = [
                'status' => 'error',
                'message' => 'Email already exists'
            ];
        }
        if ($this->doctorsModel->create($data)) {
            return $response = [
                'status' => 'success',
                'message' => 'Doctor registered successfully'
            ];
        }
        return $response = [
            'status' => 'error',
            'message' => 'Something went wrong'
        ];
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];
            $doctor = $this->doctorsModel->getByEmail($data['email']);
            if (!is_null($doctor)) {
                if (password_verify($data['password'], $doctor['password'])) {
                    session_start();
                    $_SESSION['name'] = $doctor['name'];
                    $_SESSION['id'] = $doctor['id'];
                    header('Location: /doc_care/home');
                    return null;
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Invalid email or password'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid email or password'
                ];
            }
            return $response;
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'major' => $_POST['major'],
                'degree' => $_POST['degree'],
                'available_days' => $_POST['available_days'],
                'working_hours' => $_POST['working_hours'],
                'starting_hour' => $_POST['starting_hour'],
                'ending_hour' => $_POST['ending_hour']
            ];
            $doctor = $this->doctorsModel->find($id);
            if (is_null($doctor)) {
                echo 'Doctor not found';
                return;
            }
            if ($this->doctorsModel->update($id, $data)) {
                header('Location: index.php');
            } else {
                echo 'Something went wrong';
            }
        } else {
            $doctor = $this->doctorsModel->find($id);
            if (is_null($doctor)) {
                echo 'Doctor not found';
                return;
            }
            require_once '../views/doctors/edit.php';
        }
    }
    public function delete()
    {
        $id = $_GET['id'];
        if ($this->doctorsModel->delete($id)) {
            header('Location: index.php');
        } else {
            echo 'Something went wrong';
        }
    }
    public function show($id)
    {
        $doctor = $this->doctorsModel->find($id);
        return $doctor;
    }
    public function getPatients()
    {
        $patients = $this->doctorsModel->patients();
        return $patients;
    }
}
