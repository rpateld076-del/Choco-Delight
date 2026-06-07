<?php
require_once 'config.php';
require_login();

$msg=''; 
$err='';

/* ===== ADD DELIVERY PERSON ===== */
if (
    isset($_POST['action'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['phone']) 
    && $_POST['action'] === 'add'
) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $role   = 'delivery';
    $status = 'active';

    /* 🔎 CHECK DUPLICATE EMAIL IN USERS */
    $chk = $mysqli->prepare("SELECT id FROM users WHERE email=?");
    $chk->bind_param('s', $email);
    $chk->execute();
    $chk->store_result();

    if ($chk->num_rows > 0) {
        $err = "❌ This email already exists";
    } else {

        /* ===== INSERT INTO USERS ===== */
        $stmt = $mysqli->prepare(
            "INSERT INTO users (name, email, password, phone, role, status)
             VALUES (?,?,?,?,?,?)"
        );
        $stmt->bind_param(
            'ssssss',
            $name,
            $email,
            $password,
            $phone,
            $role,
            $status
        );

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id; // Get inserted user ID

            /* ===== INSERT INTO DELIVERY_PERSON ===== */
            $stmt2 = $mysqli->prepare(
                "INSERT INTO delivery_person (id, name, email, phone, status)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt2->bind_param(
                'issss',
                $user_id, // Use same ID as in users table
                $name,
                $email,
                $phone,
                $status
            );

            if ($stmt2->execute()) {
                $msg = "✅ Delivery person added to both tables successfully";
            } else {
                $err = "❌ Insert failed in delivery_person: " . $mysqli->error;
                // Optionally rollback user insert if needed
            }
            $stmt2->close();

        } else {
            $err = "❌ Add failed in users table: " . $mysqli->error;
        }
        $stmt->close();
    }
    $chk->close();
}

/* ===== DELETE DELIVERY PERSON ===== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Delete from delivery_person first
    $stmt1 = $mysqli->prepare("DELETE FROM delivery_person WHERE id=?");
    $stmt1->bind_param('i',$id);
    $stmt1->execute();
    $stmt1->close();

    // Then delete from users
    $stmt2 = $mysqli->prepare("DELETE FROM users WHERE id=?");
    $stmt2->bind_param('i',$id);
    $stmt2->execute();
    $stmt2->close();

    header('Location: delivery.php');
    exit;
}

include 'includes.php';

/* ===== FETCH DELIVERY PERSONS ===== */
$res = $mysqli->query("
    SELECT u.id, u.name, u.email, u.phone, d.status 
    FROM users u
    LEFT JOIN delivery_person d ON u.id = d.id
    WHERE u.role='delivery'
");
?>

<div class="card">
  <h2>Manage Delivery Person</h2>

  <?php if ($msg): ?><div class="small" style="color:green"><?php echo e($msg); ?></div><?php endif; ?>
  <?php if ($err): ?><div class="small" style="color:red"><?php echo e($err); ?></div><?php endif; ?>

  <form method="post">
    <input type="hidden" name="action" value="add">

    <div class="row">
        <label>Name</label>
        <input type="text" name="name" required>
    </div>

    <div class="row">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="row">
        <label>Phone</label>
        <input type="text" name="phone" required>
    </div>

    <div class="row">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="row">
        <button class="btn" type="submit">Add</button>
    </div>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo e($r['id']); ?></td>
        <td><?php echo e($r['name']); ?></td>
        <td><?php echo e($r['email']); ?></td>
        <td><?php echo e($r['phone']); ?></td>
        <td><?php echo e($r['status'] ?: 'Not Assigned'); ?></td>
        <td>
            <a href="delivery_edit.php?id=<?php echo e($r['id']); ?>">Edit</a> |
            <a href="?delete=<?php echo e($r['id']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
