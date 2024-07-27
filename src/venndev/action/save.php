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

$updated = false;

function generateKey(string $key): string
{
    return md5($key);
}

if (
    isset($_POST['host']) && 
    isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['database']) &&
    isset($_POST['port']) && 
    isset($_POST['table']) &&
    isset($_POST['hashData']) &&
    isset($_POST['content'])
) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    $port = $_POST['port'];
    $hashData = $_POST['hashData'];
    $data = $_POST['content'];
    $table = $_POST['table'];

    //remove /n
    $data = str_replace("\n", "", $data);
    $data = str_replace("\r", "", $data);

    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->query("DROP TABLE IF EXISTS `" . $table . "`");
    $conn->query("CREATE TABLE IF NOT EXISTS `" . $table . "` (`key` VARCHAR(255) PRIMARY KEY, `value` LONGTEXT UNIQUE, FULLTEXT (`value`))");

    $generateKey = generateKey($table);

    if ($conn->connect_error) $connected = false;

    if ($hashData === true) $data = encodeData($data, $hashData);

    try {
        $i = 0;
        foreach (str_split($data, 4294967295) as $data) {
            $keyData = $generateKey . "_" . $i;
            $result = $conn->query("INSERT IGNORE INTO `" . $table . "` (`key`, `value`) VALUES ('" . $keyData . "', '" . $data . "')");
            $i++;
        }
        $updated = true;
    } catch (Exception $e) {
        $updated = false;
    }

    $conn->close();
    $connected = true;
} else {
    $connected = false;
}

echo json_encode([
    'connected' => $connected,
    'updated' => $updated
]);
?>