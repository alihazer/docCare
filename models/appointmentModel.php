<?php

namespace Models;

require_once '../config/dbConnect.php';
require_once '../models/Model.php';

use Config\Database as Database;
use Models\Model;

class Appointment extends Model
{
    private $table = 'appointments';
    private $fields = ['date', 'time', 'status', 'doctor_id', 'patient_id'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fields);
    }
    public function doctors()
    {
        return $this->belongsTo('doctors', 'doctor_id');
    }
    public function patients()
    {
        return $this->belongsTo('patients', 'patient_id');
    }
}
