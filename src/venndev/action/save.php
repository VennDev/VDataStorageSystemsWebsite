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

function generateKey(string $key): string
{
    return md5($key);
}

$conn = null;
$host = $_POST['host'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$database = $_POST['database'] ?? '';
$port = $_POST['port'] ?? '';
$hashData = $_POST['hashData'] ?? false;
$data = $_POST['content'] ?? '';
$table = $_POST['table'] ?? '';
$type = $_POST['type'] ?? '';

$generateKey = generateKey($table);

//remove /n
$data = str_replace("\n", "", $data);
$data = str_replace("\r", "", $data);

if ($hashData === 'true') $data = encodeData($data, true);

if ($type !== '') {
    if ($type === 'mysql' && $host !== '' && $username !== '' && $database !== '' && $port !== '') {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->query("DROP TABLE IF EXISTS `" . $table . "`");
        $conn->query("CREATE TABLE IF NOT EXISTS `" . $table . "` (`key` VARCHAR(255) PRIMARY KEY, `value` LONGTEXT UNIQUE, FULLTEXT (`value`))");

        if ($conn->connect_error) $connected = false;

        try {
            $i = 0;
            foreach (str_split($data, 4294967295) as $datao) {
                $keyData = $generateKey . "_" . $i;
                $result = $conn->query("INSERT IGNORE INTO `" . $table . "` (`key`, `value`) VALUES ('" . $keyData . "', '" . $datao . "')");
                $i++;
            }
            $updated = true;
        } catch (Exception $e) {
            $updated = false;
        }
    } elseif ($type === 'sqlite' && $database !== '') {
        $path = __DIR__ . '\\..\\' . $database;
        $conn = new SQLite3($path);
        $conn->query("DROP TABLE IF EXISTS `" . $table . "`");
        $conn->query("CREATE TABLE IF NOT EXISTS `" . $table . "` (`key` TEXT PRIMARY KEY, `value` TEXT UNIQUE)");

        try {
            $i = 0;
            foreach (str_split($data, 4294967295) as $datao) {
                $keyData = $generateKey . "_" . $i;
                $result = $conn->query("INSERT OR IGNORE INTO `" . $table . "` (`key`, `value`) VALUES ('" . $keyData . "', '" . $datao . "')");
                $i++;
            }

            $updated = true;
        } catch (Exception $e) {
            $updated = false;
        }
    }
    $connected = true;
} else {
    $connected = false;
}

if ($conn !== null) $conn->close();

echo json_encode([
    'connected' => $connected,
    'updated' => $updated,
    'file' => $database,
]);
?>