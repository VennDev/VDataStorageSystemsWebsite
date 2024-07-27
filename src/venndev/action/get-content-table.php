<?php

require_once '../public/php/encodeUtils.php';

header('Content-Type: application/json');

$host = '';
$username = '';
$password = '';
$database = '';
$port = '';
$table = '';
$data = "";
$hashData = false;

if (
    isset($_POST['host']) && 
    isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['database']) &&
    isset($_POST['port']) && 
    isset($_POST['table']) &&
    isset($_POST['hashData'])
) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    $port = $_POST['port'];
    $hashData = $_POST['hashData'] === 'true';

    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) $connected = false;

    $table = $_POST['table'];
    $result = $conn->query("SELECT * FROM `" . $table . "`");
    if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) $data .= $row["value"];

    if ($hashData === true) $data = decodeData($data, $hashData);
    $data = json_decode($data, true);
    $conn->close();

    $connected = true;
} else {
    $connected = false;
}

echo json_encode([
    'connected' => $connected,
    'data' => $data,
    'hashData' => $hashData
]);
?>