<?php
require_once 'c:/xampp/htdocs/choco_delight1/choco_admin/config.php';

// 1. Insert a test product with show_on_home = 0
$mysqli->query("INSERT INTO products (category_id, name, price, show_on_home) VALUES (1, 'Test Hidden Product', 10.99, 0)");
$product_id = $mysqli->insert_id;

echo "Inserted test product ID: $product_id\n";

// 2. Check if it appears in Trending Products (index.php logic)
$trending = $mysqli->query("SELECT id FROM products WHERE show_on_home = 1")->fetch_all(MYSQLI_ASSOC);
$found_in_trending = false;
foreach($trending as $p) {
    if($p['id'] == $product_id) $found_in_trending = true;
}

if($found_in_trending) {
    echo "❌ Error: Hidden product found in home page query!\n";
} else {
    echo "✅ Success: Hidden product NOT found in home page query.\n";
}

// 3. Check if it appears in listing query (product.php logic)
$listing = $mysqli->query("SELECT id FROM products")->fetch_all(MYSQLI_ASSOC);
$found_in_listing = false;
foreach($listing as $p) {
    if($p['id'] == $product_id) $found_in_listing = true;
}

if($found_in_listing) {
    echo "✅ Success: Hidden product found in general listing query.\n";
} else {
    echo "❌ Error: Hidden product NOT found in general listing query!\n";
}

// Clean up
$mysqli->query("DELETE FROM products WHERE id = $product_id");
echo "Cleaned up test product.\n";
?>
