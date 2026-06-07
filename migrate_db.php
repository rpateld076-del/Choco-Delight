<?php
require_once 'c:/xampp/htdocs/choco_delight1/choco_admin/config.php';

$sql = "ALTER TABLE products ADD COLUMN show_on_home TINYINT(1) DEFAULT 1 AFTER image";

if ($mysqli->query($sql)) {
    echo "Successfully added 'show_on_home' column.\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}
?>
