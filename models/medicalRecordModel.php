<?php

namespace Models;

require_once '../models/Model.php';

use Models\Model as Model;

class MedicalRecord extends Model
{
    private $table = 'medical_record';

    public function __construct()
    {
        parent::__construct($this->table);
    }
    public function patient()
    {
        return $this->belongsTo('patients', 'patient_id');
    }
}
