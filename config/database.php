<?php

$supabase_url = "https://iayiolnypcezhxilybzm.supabase.co";
$supabase_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlheWlvbG55cGNlemh4aWx5YnptIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzY5ODM3NTQsImV4cCI6MjA5MjU1OTc1NH0.dTms8VKyt6n3MlPmu5iHOVOna7MJFJtEPqdE3_3XloY";

class Database {
    public $url;
    public $key;
    
    public function __construct() {
        $this->url = "https://iayiolnypcezhxilybzm.supabase.co";
        $this->key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlheWlvbG55cGNlemh4aWx5YnptIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzY5ODM3NTQsImV4cCI6MjA5MjU1OTc1NH0.dTms8VKyt6n3MlPmu5iHOVOna7MJFJtEPqdE3_3XloY";
    }
    
    private function request($method, $endpoint, $body = null) {
        $ch = curl_init();
        $headers = [
            'apikey: ' . $this->key,
            'Authorization: Bearer ' . $this->key,
            'Content-Type: application/json',
            'Prefer: return=representation'
        ];
        
        $url = $this->url . $endpoint;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        if ($method === 'POST' || $method === 'PATCH' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($body) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            }
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 400) {
            throw new Exception("Error HTTP $httpCode: $response");
        }
        
        return json_decode($response, true) ?: [];
    }
    
    public function select($table, $filters = []) {
        $endpoint = "/rest/v1/$table";
        if (!empty($filters)) {
            $params = [];
            foreach ($filters as $k => $v) {
                $params[] = "$k=eq.$v";
            }
            $endpoint .= "?" . implode("&", $params);
        }
        return $this->request('GET', $endpoint);
    }
    
    public function insert($table, $data) {
        return $this->request('POST', "/rest/v1/$table", $data);
    }
    
    public function update($table, $id, $data) {
        return $this->request('PATCH', "/rest/v1/$table?id=eq.$id", $data);
    }
    
    public function delete($table, $id) {
        return $this->request('DELETE', "/rest/v1/$table?id=eq.$id");
    }
    
    public function rawQuery($sql) {
        $endpoint = "/rest/v1/rpc/exec_sql?sql=" . urlencode($sql);
        return $this->request('GET', $endpoint);
    }
    
    public function raw($table, $filters = []) {
        $endpoint = "/rest/v1/$table";
        $params = [];
        foreach ($filters as $k => $v) {
            $parts = explode('.', $v);
            if (count($parts) === 2) {
                $params[] = "$k=.$parts[0].$parts[1]";
            } else {
                $params[] = "$k=eq.$v";
            }
        }
        if (!empty($params)) {
            $endpoint .= "?" . implode("&", $params);
        }
        return $this->request('GET', $endpoint);
    }
}

$db = new Database();