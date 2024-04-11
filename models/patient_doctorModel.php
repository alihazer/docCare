<?php

namespace Models\PatientDoctor;

require_once '../models/Model.php';

use Models\Model as Model;

class PatientDoctorModel extends Model
{
    private $table = 'doctor_patient';
    private $fields = ['doctor_id', 'patient_id'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fields);
    }
}
