<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    $filePath = __DIR__ . '/' . $file;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo 'File deleted successfully.';
        } else {
            echo 'Error deleting file.';
        }
    } else {
        echo 'File not found.';
    }
} else {
    echo 'No file specified.';
}
?>