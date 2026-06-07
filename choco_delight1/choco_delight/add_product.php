<?php
include 'config.php';   // DB connection

$msg = "";

if (isset($_POST['submit'])) {

    $name  = $_POST['name'];
    $price = $_POST['price'];

    // ===== IMAGE UPLOAD =====
    if (!empty($_FILES['image']['name'])) {

        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array($ext, $allowed)) {
            $msg = "Only JPG, PNG, GIF allowed";
        } else {

            $filename = time() . "_" . uniqid() . "." . $ext;
            $path = $folder . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {

                // ===== SAVE TO DB =====
                $stmt = $conn->prepare(
                    "INSERT INTO products (name, price, image) VALUES (?,?,?)"
                );
                $stmt->bind_param("sds", $name, $price, $path);

                if ($stmt->execute()) {
                    $msg = "Product added successfully ✅";
                } else {
                    $msg = "Database error ❌";
                }

            } else {
                $msg = "Image upload failed ❌";
            }
        }
    } else {
        $msg = "Please select image";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body{font-family:Arial;background:#f5f5f5}
        .box{width:400px;margin:40px auto;background:#fff;padding:20px;border-radius:8px}
        input,button{width:100%;padding:8px;margin:8px 0}
        button{background:#8b0000;color:#fff;border:none}
        .msg{color:green}
        .err{color:red}
    </style>
</head>
<body>

<div class="box">
    <h2>Add Product</h2>

    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>

    <!-- 🔴 enctype is VERY IMPORTANT -->
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" required>
        <button type="submit" name="submit">Add Product</button>
    </form>
</div>

</body>
</html>
