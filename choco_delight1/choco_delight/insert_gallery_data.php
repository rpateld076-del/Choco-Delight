<?php
require_once 'inc/functions.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Insert Products if they don't exist (to link images to)
$products = [
    ['name' => 'Dark Chocolate Truffle', 'price' => 150, 'description' => 'Rich dark chocolate ganache rolled in cocoa.'],
    ['name' => 'Milk Hazelnut Bar', 'price' => 120, 'description' => 'Creamy milk chocolate with crunchy hazelnuts.'],
    ['name' => 'White Raspberry Delight', 'price' => 180, 'description' => 'Sweet white chocolate with tangy raspberry bits.']
];

$productIds = [];

foreach ($products as $p) {
    $check = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $check->bind_param("s", $p['name']);
    $check->execute();
    $res = $check->get_result();
    
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $productIds[$p['name']] = $row['id'];
        echo "Product '{$p['name']}' already exists (ID: {$row['id']}).<br>";
    } else {
        // Simple insert for demo purposes
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, category_id) VALUES (?, ?, ?, 'default.jpg', 1)"); // Assuming cat 1 exists
        $stmt->bind_param("sds", $p['name'], $p['price'], $p['description']);
        if ($stmt->execute()) {
            $productIds[$p['name']] = $conn->insert_id;
            echo "Created product '{$p['name']}' (ID: {$conn->insert_id}).<br>";
        } else {
            echo "Error creating '{$p['name']}': " . $conn->error . "<br>";
        }
    }
}

// 2. Insert Gallery Images
// We will use the uploaded/generated filenames here. 
// If generation failed, we might need to manually set these or use placeholders.
// For now, I'll insert records pointing to expected filenames.
$galleryItems = [
    ['product' => 'Dark Chocolate Truffle', 'filename' => 'uploads/gallery/dark_truffle.jpg', 'caption' => 'Intense cocoa flavor'],
    ['product' => 'Milk Hazelnut Bar', 'filename' => 'uploads/gallery/milk_hazelnut.jpg', 'caption' => 'Smooth and crunchy'],
    ['product' => 'White Raspberry Delight', 'filename' => 'uploads/gallery/white_raspberry.jpg', 'caption' => 'A fruity twist']
];

foreach ($galleryItems as $item) {
    $pid = $productIds[$item['product']] ?? NULL;
    $filename = $item['filename'];
    $caption = $item['caption'];

    // Check if image exists in DB
    $checkApi = $conn->prepare("SELECT id FROM gallery WHERE filename = ?");
    $checkApi->bind_param("s", $filename);
    $checkApi->execute();
    if ($checkApi->get_result()->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO gallery (product_id, filename, caption) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $pid, $filename, $caption);
        if ($stmt->execute()) {
            echo "Added gallery image for '{$item['product']}'.<br>";
        } else {
            echo "Error adding gallery image: " . $conn->error . "<br>";
        }
    } else {
        echo "Gallery image '{$filename}' already in DB.<br>";
    }
}

echo "Done.";
?>
