<?php
session_start();
require_once 'config.php'; // admin DB connection

$msg = '';

if (isset($_POST['add_delivery'])) {

    $name  = $_POST['name'];
    $email = $_POST['email'];

    // 🔐 HASH PASSWORD
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // CHECK EMAIL EXISTS
    $check = $mysqli->prepare(
        "SELECT id FROM delivery_person WHERE email=?"
    );
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already exists";
    } else {

        // INSERT DELIVERY PERSON
        $stmt = $mysqli->prepare(
            "INSERT INTO users (name,email,password,role,status,phone)
             VALUES (?,?,?)"
        );
        $stmt->bind_param('sss', $name, $email, $password, $phone);

        if ($stmt->execute()) {
            $msg = "Delivery person added successfully";
        } else {
            $msg = "Error adding delivery person";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Delivery Person</title>
</head>
<body>

<h2>Add Delivery Person</h2>

<?php if ($msg) echo "<p style='color:green'>$msg</p>"; ?>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="text" name="phone" placeholder="Phone" required><br><br>
    <button type="submit" name="add_delivery">Add</button>
</form>

</body>
</html>
