<?php
require_once 'inc/functions.php';
require_login();

$customer = get_user($_SESSION['customer_id']);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = esc($_POST['name']);
    $phone = esc($_POST['phone']);
    $address = esc($_POST['address']);
    
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $msg = "Phone number must be exactly 10 digits.";
    } else {
        $stmt = $conn->prepare("UPDATE customers SET name=?, phone=?, address=? WHERE id=?");
        $stmt->bind_param('sssi', $name, $phone, $address, $_SESSION['customer_id']);
        
        if($stmt->execute()) $msg = "Profile updated successfully!";
        else $msg = "Update failed. Please try again.";
        
        $customer = get_user($_SESSION['customer_id']);
    }
}



include 'inc/header.php'; 
?>

<style>
/* PROFILE PAGE UNIQUE STYLES */
.profile-wrapper {
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    min-height: 80vh;
    padding: 60px 0;
    font-family: 'Poppins', sans-serif;
}

.profile-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}

@media (max-width: 900px) {
    .profile-container {
        grid-template-columns: 1fr;
    }
}

/* CARDS */
.profile-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    padding: 40px;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
}

.profile-card h3 {
    font-size: 24px;
    color: #5A1E2B;
    margin-bottom: 30px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
    display: inline-block;
}

/* LEFT SIDE - USER INFO */
.user-avatar {
    width: 100px;
    height: 100px;
    background: #5A1E2B;
    color: #ffd27d;
    border-radius: 50%;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.3);
}

.welcome-text {
    text-align: center;
    margin-bottom: 30px;
}

.welcome-text h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 5px;
}

.welcome-text span {
    color: #888;
    font-size: 14px;
}

/* FORM STYLES */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: 500;
    font-size: 14px;
}

.form-group input, 
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #eee;
    background: #fcfcfc;
    border-radius: 10px;
    font-size: 14px;
    transition: 0.3s;
    outline: none;
    font-family: inherit;
}

.form-group input:focus, 
.form-group textarea:focus {
    border-color: #ffd27d;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(255, 210, 125, 0.1);
}

.btn-save {
    width: 100%;
    background: #5A1E2B;
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(90, 30, 43, 0.2);
}

.btn-save:hover {
    background: #722F37;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(90, 30, 43, 0.3);
}

/* ALERTS */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
    font-size: 14px;
}

/* RIGHT SIDE - ORDERS */
.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th {
    text-align: left;
    padding: 15px;
    color: #888;
    font-weight: 500;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #f0f0f0;
}

.orders-table td {
    padding: 18px 15px;
    border-bottom: 1px solid #f9f9f9;
    color: #444;
    font-size: 15px;
}

.orders-table tr:last-child td {
    border-bottom: none;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

.status-delivered { background: #e8f5e9; color: #2e7d32; }
.status-cancelled { background: #ffebee; color: #c62828; }
.status-pending { background: #fff8e1; color: #f57f17; }

.btn-view {
    padding: 8px 16px;
    border: 1px solid #eee;
    border-radius: 30px;
    color: #555;
    font-size: 13px;
    background: #fff;
    transition: 0.3s;
}

.btn-view:hover {
    background: #5A1E2B;
    color: #fff;
    border-color: #5A1E2B;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #999;
}
</style>

<div class="profile-wrapper">
    <div class="profile-container">
        
        <!-- LEFT COLUMN: PROFILE FORM -->
        <div class="profile-card">
            <div class="user-avatar">
                <?php echo strtoupper(substr($customer['name'], 0, 1)); ?>
            </div>
            
            <div class="welcome-text">
                <h2><?php echo esc($customer['name']); ?></h2>
                <span><?php echo esc($customer['email']); ?></span>
            </div>

            <?php if (!empty($msg)): ?>
                <div class="alert-success"><?php echo $msg; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo esc($customer['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Your Phone</label>
                    <input type="text" name="phone" value="<?php echo esc($customer['phone']); ?>" required pattern="\d{10}" minlength="10" maxlength="10" title="Please enter exactly 10 digits">
                </div>

                <div class="form-group">
                    <label>Delivery Address</label>
                    <textarea name="address" rows="3" required><?php echo esc($customer['address']); ?></textarea>
                </div>

                <button type="submit" class="btn-save">Update Profile</button>
            </form>
        </div>



    </div>
</div>

<?php include 'inc/footer.php'; ?>
