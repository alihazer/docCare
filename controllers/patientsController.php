<?php

namespace Controllers;

use Models\PatientsModel as PatientsModel;

require_once '../models/patientsModel.php';

class PatientsController
{
    private $patientsModel;

    public function __construct()
    {
        $this->patientsModel = new PatientsModel();
    }

    public function index($condition = '')
    {
        $patients = $this->patientsModel->all($condition);
        return $patients;
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = [
                'status' => 'error',
                'message' => 'Something went wrong'
            ];
            $data = [
                'name' => $_POST['name'],
                'dob' => $_POST['dob'],
                'phone_nb' => $_POST['phone_nb'],
                'medical_history' => $_POST['medical_history']
            ];
            if ($this->patientsModel->create($data)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Patient added successfully'
                ];
            }
            return $response;
        }
    }

    public function show($id)
    {
        $patient = $this->patientsModel->find($id);
        return $patient;
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'dob' => $_POST['dob'],
                'phone_nb' => $_POST['phone_nb'],
                'medical_history' => $_POST['medical_history']
            ];
            $patient = $this->patientsModel->find($id);
            if (is_null($patient)) {
                echo 'Patient not found';
                return;
            }
            if ($this->patientsModel->update($id, $data)) {
                header('Location: index.php');
            } else {
                echo 'Something went wrong';
            }
        } else {
            $patient = $this->patientsModel->find($id);
            if (is_null($patient)) {
                echo 'Patient not found';
                return;
            }
            require_once '../views/patients/edit.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $patient = $this->patientsModel->find($id);
        if ($this->patientsModel->delete($id)) {
            return $response = [
                'status' => 'success',
                'message' => 'Patient removed successfully'
            ];
        } else {
            return $response = [
                'status' => 'error',
                'message' => 'Something went wrong'
            ];
        }
    }
}
