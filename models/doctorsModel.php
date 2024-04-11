<?php

namespace Models;

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}
require_once ROOT_PATH . '/models/model.php';


use Models\Model as Model;

class DoctorsModel extends Model
{
    private $table = 'doctors';
    private $fields = ['name', 'email', 'password', 'major', 'degree', 'available_days', 'working_hours', 'starting_hour', 'ending_hour'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fields);
    }
    public function patients()
    {
        return $this->belongsToMany('patients', 'doctor_patient', 'doctor_id', 'patient_id');
    }
    public function appointments()
    {
        return $this->hasMany('appointments', 'doctor_id');
    }
}
