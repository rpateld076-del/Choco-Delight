<?php
require_once 'inc/functions.php';

$res = $conn->query("SELECT id FROM gallery WHERE (caption IS NULL OR caption = '') AND product_id IS NULL");
$i = 1;
while($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $newName = "Signature Delight #$id";
    $conn->query("UPDATE gallery SET caption = '$newName' WHERE id = $id");
    echo "Updated Gallery ID $id to '$newName'<br>";
}

echo "Done.";
?>
