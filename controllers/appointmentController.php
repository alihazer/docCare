<?php

namespace Controllers;

use Models\Appointment as AppointmentsModel;
use Controllers\PatientDoctorController as PatientDoctorController;

require_once '../models/appointmentModel.php';
require_once '../controllers/patient_doctorController.php';

class AppointmentsController
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentsModel();
    }

    public function index($condition = '')
    {
        $appointments = $this->appointmentModel->all($condition);
        return $appointments;
    }


    public function add()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'appointment_date' => $_POST['date'],
                'appointment_time' => $_POST['time'],
                'doctor_id' => $_POST['doctor_id'],
                'patient_id' => $_POST['patient_id']
            ];
            $jaafar = $this->appointmentModel->create($data);
            $patientDoctor = new PatientDoctorController();
            // Check if the patient is already assigned to the doctor
            $condition = "doctor_id = " . $_POST['doctor_id'] . " AND patient_id = " . $_POST['patient_id'];
            $isAssigned = $patientDoctor->all($condition);
            if (!empty($isAssigned)) {
                return $response = [
                    'status' => 'success',
                    'message' => 'Appointment added successfully'
                ];
            } else {
                $data = [
                    'doctor_id' => $_POST['doctor_id'],
                    'patient_id' => $_POST['patient_id']
                ];
                $appointment = $patientDoctor->add($data);
            }

            if (!$appointment || !$jaafar) {
                echo 'Something went wrong';
                $response = [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ];
                return $response;
            }
            return $response = [
                'status' => 'success',
                'message' => 'Appointment added successfully'
            ];
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'date' => $_POST['date'],
                'time' => $_POST['time'],
                'status' => $_POST['status'],
                'doctor_id' => $_POST['doctor_id'],
                'patient_id' => $_POST['patient_id']
            ];
            $appointment = $this->appointmentModel->find($id);
            if (is_null($appointment)) {
                echo 'Appointment not found';
                return;
            }
            if ($this->appointmentModel->update($id, $data)) {
                header('Location: index.php');
            } else {
                echo 'Something went wrong';
            }
        } else {
            $appointment = $this->appointmentModel->find($_GET['id']);
            require_once '../views/appointments/edit.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        if ($this->appointmentModel->delete($id)) {
            header('Location: index.php');
        } else {
            echo 'Something went wrong';
        }
    }
    public function changeStatus($id, $status)
    {

        $appointment = $this->appointmentModel->find($id);
        $data = [
            'patient_id' => $appointment['patient_id'],
            'appointment_date' => $appointment['appointment_date'],
            'appointment_time' => $appointment['appointment_time'],
            'notes' => $appointment['notes'],
            'doctor_id' => $appointment['doctor_id'],
            'status' => $status
        ];
        if ($this->appointmentModel->update($id, $data)) {
            return $this->appointmentModel->find($id);
        }
        return null;
    }
    public function show($id)
    {
        $appointment = $this->appointmentModel->find($id);
        return $appointment;
    }
}
