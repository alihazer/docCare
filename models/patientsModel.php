<?php

namespace Models;

require_once '../config/dbConnect.php';
require_once '../models/Model.php';

use Models\Model;
use Config\Database as Database;

class PatientsModel extends Model
{
    private $table = 'patients';
    private $fields = ['name', 'dob', 'phone_nb', 'medical_history'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fields);
    }
    public function doctors()
    {
        return $this->belongsToMany('doctors', 'doctor_patient', 'patient_id', 'doctor_id');
    }
    public function appointments()
    {
        return $this->hasMany('appointments', 'patient_id');
    }
    public function medicalRecords()
    {
        return $this->hasMany('medical_records', 'patient_id');
    }
};
