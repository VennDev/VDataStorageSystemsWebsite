<?php

require_once '../public/php/encodeUtils.php';

header('Content-Type: application/json');

if (!isset($_POST['type'])) {
    echo json_encode([
        'connected' => false,
        'updated' => false
    ]);
    exit;
}

$conn = null;
$host = $_POST['host'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$port = $_POST['port'] ?? '';
$hashData = $_POST['hashData'] ?? false;
$type = $_POST['type'] ?? '';
$database = $_POST['database'] ?? '';
$data = '';

if ($type === 'mysql' && $host !== '' && $username !== '' && $database !== '' && $port !== '') {
    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) $connected = false;

    $table = $_POST['table'];
    $result = $conn->query("SELECT * FROM `" . $table . "`");
    if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) $data .= $row["value"];

    if ($hashData === 'true') $data = decodeData($data, true);
    $connected = true;
} elseif ($type === 'sqlite' && $database !== '') {
    $conn = new SQLite3(__DIR__ . '\\..\\' . $database);
    $table = $_POST['table'];
    $result = $conn->query("SELECT * FROM `" . $table . "`");
    if ($result !== false) {
        while ($row = $result->fetchArray()) $data .= $row["value"];
    } else {
        $connected = false;
    }

    if ($hashData === 'true') $data = decodeData($data, true);
    $connected = true;
} else {
    $connected = false;
}

$data = json_decode($data, true);

if ($conn !== null) $conn->close();

echo json_encode([
    'connected' => $connected,
    'data' => $data,
    'hashData' => $hashData
]);
?>