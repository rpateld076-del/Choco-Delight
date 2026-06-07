<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us | ChocoDelight</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'inc/header.php'; ?>
<style>
/* ===============================
   CONTACT PAGE STYLES
================================ */
.contact-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
}

.contact-info {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.contact-info h3 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #3b1f1f;
}

.contact-info p {
    margin-bottom: 12px;
    color: #555;
}

.contact-info p strong {
    color: #000;
}

.contact-form {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.contact-form h3 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #3b1f1f;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 14px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 15px;
}

.contact-form textarea {
    resize: none;
    height: 120px;
}

.contact-form button {
    width: 100%;
    padding: 14px;
    background: #b84d4d;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.contact-form button:hover {
    background: #3b1f1f;
}
</style>
</head>

<body>

<!-- ===============================
     CONTACT US
================================ -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Contact <span>Us</span></h2>

        <div class="contact-wrapper">
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p><strong>📍 Address:</strong> Ahmedabad, Gujarat, India</p>
                <p><strong>📞 Phone:</strong> +91 98765 43210</p>
                <p><strong>📧 Email:</strong> support@chocodelight.com</p>
                <p>
                    Have questions or custom chocolate requests?  
                    We’d love to hear from you!
                </p>
            </div>

            <div class="contact-form">
                <h3>Send Message</h3>
                
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = esc($_POST['name'] ?? '');
                    $email = esc($_POST['email'] ?? '');
                    $message = esc($_POST['message'] ?? '');

                    if ($name && $email && $message) {
                        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $name, $email, $message);
                        if ($stmt->execute()) {
                            echo '<div style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;">Message sent successfully!</div>';
                        } else {
                            echo '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">Failed to send message.</div>';
                        }
                    } else {
                         echo '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">All fields are required.</div>';
                    }
                }
                ?>

                <form method="post">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>

</body>
</html>
