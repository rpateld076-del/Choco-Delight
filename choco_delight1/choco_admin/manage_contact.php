<?php
require_once 'config.php';
require_once 'includes.php';

// Delete message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM contact_messages WHERE id = $id");
    echo "<script>alert('Message deleted successfully'); window.location.href='manage_contact.php';</script>";
}

// Fetch messages
$messages = $mysqli->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="top-actions">
        <h2>Manage Contact Messages</h2>
    </div>

    <?php if (empty($messages)): ?>
        <p>No messages found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?php echo $msg['id']; ?></td>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                    <td><?php echo date('d M Y, h:i A', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <a href="manage_contact.php?delete=<?php echo $msg['id']; ?>" class="btn danger" onclick="return confirmDelete()">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
