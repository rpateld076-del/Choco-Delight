<?php
$conn = new mysqli('localhost', 'root', '', 'choco_delight');
if ($conn->connect_error) die($conn->connect_error);

echo "--- PRODUCTS IMAGES ---\n";
$res = $conn->query("SELECT DISTINCT image FROM products WHERE image != 'default.jpg' AND image IS NOT NULL");
while($row = $res->fetch_assoc()) {
    echo $row['image'] . "\n";
}

echo "\n--- UPLOADS FOLDER ---\n";
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/choco_delight1/choco_admin/uploads/');
foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
    if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|webp)$/i', $filename)) {
        echo $filename . "\n";
    }
}

?>