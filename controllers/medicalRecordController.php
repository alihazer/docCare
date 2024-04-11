<?php

namespace Controllers;

require_once '../models/medicalRecordModel.php';

use Models\MedicalRecord as MedicalRecord;


class MedicalRecordController
{
    private $medicalRecord;

    public function __construct()
    {
        $this->medicalRecord = new MedicalRecord();
    }

    public function index()
    {
        $data = $this->medicalRecord->all();
        return $data;
    }
    public function add($data)
    {
        $result = $this->medicalRecord->create($data);
        return $result;
    }

    public function show($id, $rows = '*', $condition = '')
    {
        if (!empty($condition)) {
            $data = $this->medicalRecord->all($id, $rows, $condition);
            return $data;
        }
        $data = $this->medicalRecord->find($id);
        return $data;
    }

    public function update($id, $data)
    {
        $result = $this->medicalRecord->update($id, $data);
        return $result;
    }

    public function patient()
    {
        $data = $this->medicalRecord->patient();
        return $data;
    }
}
