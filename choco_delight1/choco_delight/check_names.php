<?php
require_once 'inc/functions.php';
$res = $conn->query("SELECT g.id, g.caption, p.name AS product_name FROM gallery g LEFT JOIN products p ON g.product_id = p.id");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Product Name: " . $row['product_name'] . " | Gallery Caption: " . $row['caption'] . "\n";
}
?>
