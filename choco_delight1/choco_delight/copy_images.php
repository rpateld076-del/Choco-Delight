<?php
$source = '../choco_admin/uploads/gallery/g_695f6a0d42a01.jpg';
$targets = [
    '../choco_admin/uploads/gallery/dark_truffle.jpg',
    '../choco_admin/uploads/gallery/milk_hazelnut.jpg',
    '../choco_admin/uploads/gallery/white_raspberry.jpg'
];

if (file_exists($source)) {
    foreach ($targets as $target) {
        if (copy($source, $target)) {
            echo "Copied to $target\n";
        } else {
            echo "Failed to copy to $target\n";
        }
    }
} else {
    echo "Source file not found: $source\n";
    // Try absolute path if relative fails, though relative should work from choco_delight
    $source = 'c:/xampp/htdocs/choco_delight1/choco_admin/uploads/gallery/g_695f6a0d42a01.jpg';
    if (file_exists($source)) {
         foreach ($targets as $target) {
            if (copy($source, $target)) {
                echo "Copied to $target\n";
            } else {
                echo "Failed to copy to $target\n";
            }
        }
    }
}
?>
