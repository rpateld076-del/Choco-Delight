<?php
require_once 'inc/functions.php';

// 1. Update Video Path in gallery.php (Manual edit needed, this script is for DB)
// We found c:\xampp\htdocs\choco_delight1\choco_delight\assets\videos\hero.mp4
// Relative path from gallery.php (in choco_delight) is: assets/videos/hero.mp4

// 2. Find Distinct Images
// I will look for images in choco_admin/uploads/
$baseDir = __DIR__ . '/../choco_admin/uploads/';
$images = glob($baseDir . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);
// add gallery subfolder
$galleryImages = glob($baseDir . 'gallery/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
$allImages = array_merge($images, $galleryImages);

$distinctImages = [];
if (count($allImages) < 3) {
    echo "Not enough images found. reusing what we have.<br>";
    // Fallback: just use whatever we have, even if duplicated, but try to shift common ones
    $distinctImages = $allImages;
} else {
    // Pick 3 random distinct ones
    shuffle($allImages);
    $distinctImages = array_slice($allImages, 0, 3);
}

// Map back to relative paths for DB
// DB expects: choco_admin/uploads/...
$webPaths = [];
foreach ($distinctImages as $img) {
    // Convert absolute path to relative to project root (approximately)
    // $img is C:\xampp\htdocs\choco_delight1\choco_admin\uploads\foo.jpg
    // we want choco_admin/uploads/foo.jpg
    $parts = explode('choco_delight1/', str_replace('\\', '/', $img));
    if (isset($parts[1])) {
        $webPaths[] = $parts[1];
    }
}

// 3. Update Gallery Table
// I'll update the 3 existing rows (ids 1, 2, 3 likely, or whatever was inserted)
$res = $conn->query("SELECT id FROM gallery ORDER BY id LIMIT 3");
$ids = [];
while ($row = $res->fetch_assoc()) {
    $ids[] = $row['id'];
}

foreach ($ids as $k => $id) {
    if (isset($webPaths[$k])) {
        $filename = $webPaths[$k];
        $stmt = $conn->prepare("UPDATE gallery SET filename = ? WHERE id = ?");
        $stmt->bind_param("si", $filename, $id);
        $stmt->execute();
        echo "Updated Gallery ID $id to use image: $filename<br>";
    }
}
?>
