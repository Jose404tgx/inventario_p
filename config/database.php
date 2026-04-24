<?php

class Database {
    private $host = "sql301.infinityfree.com";
    private $db = "if0_XXXXXXXXX";  // Tu nombre de DB de InfinityFree
    private $user = "if0_XXXXXXXXX"; // Tu usuario de InfinityFree
    private $pass = "XXXXXXXXXX";    // Tu password de InfinityFree
    
    public $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->db;charset=utf8",
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
    public function select($table, $filters = [], $join = null) {
        $sql = "SELECT * FROM $table";
        
        if ($join) {
            $sql = "SELECT $table.*, $join.nombre AS categoria 
                    FROM $table 
                    LEFT JOIN $join ON $table.categoria_id = $join.id";
        }
        
        $params = [];
        
        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $k => $v) {
                $conditions[] = "$k = ?";
                $params[] = $v;
            }
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY id DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $data) {
        $keys = array_keys($data);
        $fields = implode(", ", $keys);
        $placeholders = implode(", ", array_fill(0, count($keys), "?"));
        
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }
    
    public function update($table, $id, $data) {
        $sets = [];
        foreach (array_keys($data) as $k) {
            $sets[] = "$k = ?";
        }
        
        $sql = "UPDATE $table SET " . implode(", ", $sets) . " WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function delete($table, $id) {
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

$db = new Database();