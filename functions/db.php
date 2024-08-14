<?php
function connect()
{
    $config = file_get_contents("./app_setting.json");
    $config = json_decode($config, true);
    $host = $config['host'];
    $user = $config['user'];
    $pass = $config['password'];
    $db = $config['database'];
    $conn = new mysqli("$host", "$user", "$pass", "$db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function select($sql)
{
    $conn = connect();
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function findById($sql){
    $data = select($sql);
    if(count($data) > 0){
        return $data[0];
    }
    return null;
}