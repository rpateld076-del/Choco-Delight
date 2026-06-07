<?php
require_once 'config.php';
require_login();
require_once 'includes.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    echo "<script>alert('Invalid ID'); window.location.href='feedback.php';</script>";
    exit;
}

// Fetch feedback details
$stmt = $mysqli->prepare("SELECT * FROM feedback WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$feedback = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$feedback) {
    echo "<script>alert('Feedback not found'); window.location.href='feedback.php';</script>";
    exit;
}

// Handle sending reply
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $feedback['email'];
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    // Simple mail headers
    $headers = "From: admin@chocodelight.com\r\n";
    $headers .= "Reply-To: admin@chocodelight.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Try to send email
    // Use @ to suppress warning on localhost if no mail server is configured
    $sent = @mail($to, $subject, $message, $headers);

    if ($sent) {
        echo "<script>alert('Reply sent successfully!'); window.location.href='feedback.php';</script>";
    } else {
        // Fallback for localhost/testing where mail server isn't set up
        // We simulate success so the admin flow isn't broken
        $error_msg = "Note: Email could not be sent (No mail server configured).";
        echo "<script>alert('Reply simulated! (Localhost mode)\\n$error_msg'); window.location.href='feedback.php';</script>";
    }
}
?>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <h2>Reply to Feedback</h2>
    
    <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <p><strong>Customer:</strong> <?php echo e($feedback['customer_name']); ?></p>
        <p><strong>Original Message:</strong><br><em><?php echo nl2br(e($feedback['message'])); ?></em></p>
    </div>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="row">
            <label>To:</label>
            <input type="text" value="<?php echo e($feedback['email']); ?>" readonly style="background: #eee;">
        </div>
        
        <div class="row">
            <label>Subject:</label>
            <input type="text" name="subject" value="Re: Your Feedback to Choco Delight" required>
        </div>
        
        <div class="row">
            <label>Message:</label>
            <textarea name="message" rows="10" required placeholder="Write your reply here..."></textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Send Reply</button>
            <a href="feedback.php" class="btn danger" style="text-decoration: none; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
