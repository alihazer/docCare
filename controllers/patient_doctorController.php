<?php

namespace Controllers;

require_once '../models/patient_doctorModel.php';

use Models\PatientDoctor\PatientDoctorModel as PatientDoctorModel;

class PatientDoctorController
{
    private $model;
    public function __construct()
    {
        $this->model = new PatientDoctorModel();
    }
    public function add()
    {
        $data = [
            'doctor_id' => $_POST['doctor_id'],
            'patient_id' => $_POST['patient_id']
        ];
        return $this->model->create($data);
    }
    public function delete()
    {
        $id = $_GET['id'];
        if ($this->model->delete($id)) {
            return $response = [
                'status' => 'success',
                'message' => 'Patient removed from doctor successfully'
            ];
        }
        return $response = [
            'status' => 'error',
            'message' => 'Something went wrong'
        ];
    }
    public function all($condition = '')
    {
        return $this->model->all($condition);
    }
}
