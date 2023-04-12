<?php

namespace Korkz\Server\App\Connect;

use Exception;
use PDO;
use PDOException;

class DbOperations extends DbConnection
{
    private ?PDO $conn = null;

    public function __construct()
    {
        parent::__construct();
        $this->conn = self::connect();
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function insertData(string $table, array $data): bool
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', array_fill(0, count($values), '?')) . ")";
        try {
            $stmt = $this->conn->prepare($sql);
            // using bindParam
            foreach ($values as $index => $value) {
                $stmt->bindParam($index + 1, $values[$index]);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving data from $table: " . $e->getMessage());
        }
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return bool
     * @throws Exception
     */
    public function updateData(string $table, array $data, array $where): bool
    {
        $setValues = [];
        $whereValues = [];
        $params = array_merge(array_values($data), array_values($where));
        foreach ($data as $key => $value) {
            $setValues[] = "$key=?";
        }
        foreach ($where as $key => $value) {
            $whereValues[] = "$key=?";
        }
        $sql = "UPDATE $table SET " . implode(',', $setValues) . " WHERE " . implode(' AND ', $whereValues);
        try {
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $index => $value) {
                $stmt->bindValue($index + 1, $value);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving data from $table: " . $e->getMessage());
        }
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $where
     * @param string $orderBy
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function getData(string $table, array $columns = ['*'], array $where = [], string $orderBy = '', int $limit = 0): array
    {
        $sql = "SELECT " . implode(',', $columns) . " FROM $table";
        if (!empty($where)) {
            $whereValues = [];
            foreach ($where as $key => $value) {
                $whereValues[] = "$key = ?";
            }
            $sql .= " WHERE " . implode(' AND ', $whereValues);
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }
        if (!empty($limit)) {
            if (is_numeric($limit)) {
                $sql .= " LIMIT " . intval($limit);
            }
        }
        try {
            $stmt = $this->conn->prepare($sql);
            foreach ($where as $index => $value) {
                $stmt->bindParam((int)$index + 1, $where[$index]);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error retrieving data from $table: " . $e->getMessage());
        }
    }


    /**
     * @param string $table
     * @param array $where
     * @return bool
     * @throws Exception
     */
    public function deleteData(string $table, array $where): bool
    {
        $whereValues = [];
        foreach ($where as $key => $value) {
            $whereValues[] = "$key = ?";
        }
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $whereValues);
        try {
            $stmt = $this->conn->prepare($sql);
            foreach ($where as $index => $value) {
                $stmt->bindParam((int)$index + 1, $where[$index]);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error deleting data from $table: " . $e->getMessage());
        }
    }



    public function __destruct()
    {
        if ($this->conn instanceof PDO) {
            $this->conn = null;
        }
    }
}
