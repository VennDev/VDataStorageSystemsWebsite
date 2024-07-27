<?php
header('Content-Type: application/json');

$host = '';
$username = '';
$password = '';
$database = '';
$port = '';
$tables = [];

if (isset($_POST['host']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['database']) &&isset($_POST['port'])) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    $port = $_POST['port'];

    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) $connected = false;

    $connected = true;

    $result = $conn->query("SHOW TABLES");
    if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) $tables[] = $row["Tables_in_" . $database];

    $conn->close();
} else {
    $connected = false;
}

echo json_encode([
    'connected' => $connected,
    'tables' => $tables
]);
?>