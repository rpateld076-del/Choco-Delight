<?php
require_once 'inc/functions.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. TRUNCATE Gallery and Products (optional, but requested to remove old images)
// We will only truncate gallery to be safe, maybe users want to keep other products.
// User said "remove a old images", so truncating Gallery table is what they want.
$conn->query("TRUNCATE TABLE gallery");
echo "Gallery table truncated.<br>";

// 2. Ensure Products Exist
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
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, category_id) VALUES (?, ?, ?, 'default.jpg', 1)"); 
        $stmt->bind_param("sds", $p['name'], $p['price'], $p['description']);
        if ($stmt->execute()) {
            $productIds[$p['name']] = $conn->insert_id;
        }
    }
}

// 3. Insert Gallery Images with CORRECT PATHS
// Path should be relative to WEB ROOT if using BASE_URL, or relative to this script?
// gallery.php uses: BASE_URL . $filename
// BASE_URL is /choco_delight1/
// So we need: choco_admin/uploads/gallery/dark_truffle.jpg
$galleryItems = [
    ['product' => 'Dark Chocolate Truffle', 'filename' => 'choco_admin/uploads/gallery/dark_truffle.jpg', 'caption' => 'Intense cocoa flavor'],
    ['product' => 'Milk Hazelnut Bar', 'filename' => 'choco_admin/uploads/gallery/milk_hazelnut.jpg', 'caption' => 'Smooth and crunchy'],
    ['product' => 'White Raspberry Delight', 'filename' => 'choco_admin/uploads/gallery/white_raspberry.jpg', 'caption' => 'A fruity twist']
];

foreach ($galleryItems as $item) {
    $pid = $productIds[$item['product']] ?? NULL;
    $filename = $item['filename'];
    $caption = $item['caption'];

    $stmt = $conn->prepare("INSERT INTO gallery (product_id, filename, caption) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $pid, $filename, $caption);
    if ($stmt->execute()) {
        echo "Inserted '{$item['product']}' with path '{$filename}'.<br>";
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }
}

echo "Done.";
?>
