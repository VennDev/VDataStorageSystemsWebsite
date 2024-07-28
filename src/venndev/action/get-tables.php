<?php
header('Content-Type: application/json');

$conn = null;
$host = $_POST['host'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$database = $_POST['database'] ?? '';
$port = $_POST['port'] ?? '';
$type = $_POST['type'] ?? '';
$tables = [];

if (!isset($_POST['type'])) {
    echo json_encode([
        'connected' => false,
        'tables' => []
    ]);
    exit;
}

if ($type === 'mysql' && $host !== '' && $username !== '' && $database !== '' && $port !== '') {
    try {
        $conn = new mysqli($host, $username, $password, $database, $port);

        if ($conn->connect_error) $connected = false;

        $connected = true;

        $result = $conn->query("SHOW TABLES");
        if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) $tables[] = $row["Tables_in_" . $database];
    } catch (Throwable $e) {
        $connected = false;
    }
} elseif ($type === 'sqlite' && $database !== '') {
    try {
        $conn = new SQLite3(__DIR__ . '\\..\\' . $database);
        $connected = true;
        $result = $conn->query("SELECT name FROM sqlite_master WHERE type='table'");

        if ($result !== false) {
            while ($row = $result->fetchArray()) $tables[] = $row[0];
        } else {
            $connected = false;
        }
    } catch (Throwable $e) {
        $connected = false;
    }
} else {
    $connected = false;
}

if ($conn !== null) $conn->close();

echo json_encode([
    'connected' => $connected,
    'tables' => $tables
]);
?>