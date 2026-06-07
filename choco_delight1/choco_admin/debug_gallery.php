<?php
require_once 'config.php';
$res = $mysqli->query("SELECT * FROM gallery");
echo "<pre>";
while($row = $res->fetch_assoc()) {
    print_r($row);
    echo "File exists? " . (file_exists(__DIR__ . '/' . $row['filename']) ? "YES" : "NO") . "\n";
}
echo "</pre>";
