<?php
require_once 'inc/functions.php';

// Data for 3 distinct items
$galleryData = [
    [
        'name' => 'Luxury Belgian Pralines',
        'image' => 'choco_admin/uploads/p_697f397463bcf.jpg',
        'caption' => 'A selection of finest Belgian pralines'
    ],
    [
        'name' => 'Dark Chocolate Ganache',
        'image' => 'choco_admin/uploads/p_697f3b4978e78.jpg',
        'caption' => 'Rich, smooth cocoa sensations'
    ],
    [
        'name' => 'Hazelnut Mousse Delight',
        'image' => 'choco_admin/uploads/p_697f3c05e8e4c.jpg',
        'caption' => 'Creamy hazelnut filling in milk chocolate'
    ]
];

// Clean current gallery to ensure focus on new ones
$conn->query("TRUNCATE TABLE gallery");
echo "Gallery truncated.<br>";

foreach ($galleryData as $item) {
    // We'll insert these as standalone gallery items (product_id NULL or we can link to a placeholder product)
    // For now, standalone is fine as gallery.php handles NULL product_id by showing caption.
    $stmt = $conn->prepare("INSERT INTO gallery (filename, caption) VALUES (?, ?)");
    $stmt->bind_param("ss", $item['image'], $item['name']); // Use name as caption for display
    if ($stmt->execute()) {
        echo "Added '{$item['name']}' with image '{$item['image']}'.<br>";
    } else {
        echo "Error: " . $conn->error . "<br>";
    }
}

echo "Done.";
?>
