<?php
require_once 'config.php';
require_login();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: feedback.php'); exit; }

$msg = $err = '';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $name = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);

    $stmt = $mysqli->prepare("UPDATE feedback SET customer_name=?, email=?, message=?, rating=? WHERE id=?");
    $stmt->bind_param('sssii', $name, $email, $message, $rating, $id);
    if ($stmt->execute()) {
        $msg = "Feedback updated successfully";
    } else {
        $err = "Update failed: " . $mysqli->error;
    }
    $stmt->close();
}

$feedback = $mysqli->query("SELECT * FROM feedback WHERE id=$id")->fetch_assoc();
if (!$feedback) { header('Location: feedback.php'); exit; }

include 'includes.php';
?>
<div class="card">
    <div class="right"><a href="feedback.php" class="btn">Back to List</a></div>
    <h2>Edit Feedback</h2>

    <?php if ($msg): ?><div style="color:green; margin-bottom:10px;"><?php echo e($msg); ?></div><?php endif; ?>
    <?php if ($err): ?><div style="color:red; margin-bottom:10px;"><?php echo e($err); ?></div><?php endif; ?>

    <form method="post" style="max-width:500px">
        <input type="hidden" name="action" value="update">
        
        <div class="row">
            <label>Customer Name</label>
            <input type="text" name="customer_name" value="<?php echo e($feedback['customer_name']); ?>" required>
        </div>

        <div class="row">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo e($feedback['email']); ?>" required>
        </div>

        <div class="row">
            <label>Message</label>
            <textarea name="message" rows="5" required><?php echo e($feedback['message']); ?></textarea>
        </div>

        <div class="row">
            <label>Rating (1-5)</label>
            <select name="rating">
                <?php for($i=1; $i<=5; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php if($i == $feedback['rating']) echo 'selected'; ?>><?php echo $i; ?> Star</option>
                <?php endfor; ?>
            </select>
        </div>

        <button type="submit" class="btn">Update Feedback</button>
    </form>
</div>
<?php include 'footer.php'; ?>
