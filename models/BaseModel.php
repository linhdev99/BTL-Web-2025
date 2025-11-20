<?php

namespace Models;

use Database\Database;
use PDO;

class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /*
    |-------------------------------------
    | Select nhiều row
    |-------------------------------------
    */
    public function getAll(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |-------------------------------------
    | Select một row
    |-------------------------------------
    */
    public function getOne(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |-------------------------------------
    | Insert
    |-------------------------------------
    */
    public function insert(string $table, array $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        // trả về id mới thêm
        return $this->db->lastInsertId();
    }

    /*
    |-------------------------------------
    | Update
    |-------------------------------------
    */
    public function update(string $table, array $data, string $where, array $whereParams)
    {
        $fields = "";
        foreach ($data as $key => $val) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ", ");

        $sql = "UPDATE {$table} SET {$fields} WHERE {$where}";

        $params = array_merge($data, $whereParams);

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /*
    |-------------------------------------
    | Delete
    |-------------------------------------
    */
    public function delete(string $table, string $where, array $whereParams)
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($whereParams);
    }

    /*
    |-------------------------------------
    | Query tùy ý (custom)
    |-------------------------------------
    */
    public function query(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
