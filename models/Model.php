<?php

namespace Models;

use Config\Database;


if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}
require_once ROOT_PATH . '/config/dbConnect.php';

class Model
{

    private $db;
    private $table;
    private $fields;
    private $primaryKey;

    public function __construct($table, $fields = [])
    {
        $this->db = new Database();
        $this->table = $table;
        $this->fields = $fields;
        $this->primaryKey = 'id';
    }
    public function create($data)
    {
        if (isset($data['id'])) {
            // Unset the id field if it exists
            unset($data['id']);
        }
        $fields = implode(',', array_keys($data));
        $values = implode("','", array_values($data));
        $query = "INSERT INTO $this->table ($fields) VALUES ('$values')";
        $result = mysqli_query($this->db->getConnection(), $query);
        // THe result format is either true or false
        return $result;
    }
    public function find($id, $rows = '*')
    {
        $query = "SELECT $rows FROM $this->table WHERE id = $id";
        $result = mysqli_query($this->db->getConnection(), $query);
        if (mysqli_num_rows($result) == 0) {
            return null;
        }
        return mysqli_fetch_assoc($result);
    }
    public function all($condition = '')
    {
        $query = "SELECT * FROM $this->table";

        // If a condition is provided, append it to the query
        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        $result = mysqli_query($this->db->getConnection(), $query);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function update($id, $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . "='" . $value . "',";
        }
        $fields = rtrim($fields, ',');
        $query = "UPDATE $this->table SET $fields WHERE id = $id";
        $result = mysqli_query($this->db->getConnection(), $query);
        return $result;
    }

    public function getByEmail($email)
    {
        $query = "SELECT * FROM $this->table WHERE email = '$email'";
        $result = mysqli_query($this->db->getConnection(), $query);
        if (mysqli_num_rows($result) == 0 || !$result) {
            return false;
        }
        $result1 = mysqli_fetch_assoc($result);
        return $result1;
    }
    public function getByEmail1($email)
    {
        $query = "SELECT * FROM $this->table WHERE email = '$email'";
        $result = mysqli_query($this->db->getConnection(), $query);
        if (mysqli_num_rows($result) == 0 || !$result) {
            return false;
        }
        return true;
    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->table WHERE id = $id";
        $result = mysqli_query($this->db->getConnection(), $query);
        return $result;
    }

    public function hasMany($table, $foreign_key)
    {
        $query = "SELECT * FROM $table WHERE $foreign_key = $table.id";
        $result = mysqli_query($this->db->getConnection(), $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    public function belongsTo($table, $foreign_key)
    {
        $query = "SELECT * FROM $table JOIN $this->table ON $table.id = $this->table.$foreign_key";
        $result = mysqli_query($this->db->getConnection(), $query);
        return mysqli_fetch_assoc($result);
    }
    public function belongsToMany($table, $pivot_table, $foreign_key, $local_key)
    {
        $query = "SELECT * FROM $table JOIN $pivot_table ON $table.id = $pivot_table.$foreign_key WHERE $pivot_table.$local_key = $this->primaryKey";
        $result = mysqli_query($this->db->getConnection(), $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    public function hasOne($table, $foreign_key)
    {
        $query = "SELECT * FROM $table WHERE $foreign_key = $this->primaryKey";
        $result = mysqli_query($this->db->getConnection(), $query);
        return mysqli_fetch_assoc($result);
    }
    public function getByFilter($filter, $operation = '=')
    {
        $column = $filter['column'];
        $value = $filter['value'];
        if ($operation == 'like') {
            $value = "%$value%";
        }
        $query = "SELECT * FROM $this->table WHERE $column = '$value'";
        $result = mysqli_query($this->db->getConnection(), $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}
