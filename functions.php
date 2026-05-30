<?php

function db() {
    static $conn;
    
    if (!$conn) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            die('❌ Database Error: ' . $conn->connect_error);
        }
        
        $conn->set_charset('utf8mb4');
    }
    
    return $conn;
}

function query($sql) {
    return db()->query($sql);
}

function escape($str) {
    return db()->real_escape_string($str);
}

function getRow($sql) {
    $result = query($sql);
    return $result ? $result->fetch_assoc() : null;
}

function getAll($sql) {
    $result = query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function insert($table, $data) {
    $keys = array_keys($data);
    $values = array_map(function($v) {
        return "'" . escape($v) . "'";
    }, array_values($data));
    
    $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
    query($sql);
    
    return db()->insert_id;
}

function update($table, $data, $where) {
    $sets = [];
    foreach ($data as $key => $value) {
        $sets[] = "$key = '" . escape($value) . "'";
    }
    
    $sql = "UPDATE $table SET " . implode(', ', $sets) . " WHERE $where";
    return query($sql);
}

function count_rows($table, $where = '') {
    $sql = "SELECT COUNT(*) as count FROM $table";
    if ($where) $sql .= " WHERE $where";
    
    $result = query($sql);
    return $result->fetch_assoc()['count'];
}

function paginate($page = 1, $limit = 15) {
    $page = max(1, (int)$page);
    $offset = ($page - 1) * $limit;
    return ['limit' => $limit, 'offset' => $offset, 'page' => $page];
}

?>
