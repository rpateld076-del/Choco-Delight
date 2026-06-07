<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About & Contact | ChocoDelight</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ===============================
   GLOBAL RESET
================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f6f7fb;
    color: #333;
    line-height: 1.6;
}

/* ===============================
   COMMON
================================ */
.container {
    width: 92%;
    max-width: 1200px;
    margin: auto;
}

.section {
    padding: 60px 0;
}

.section-title {
    text-align: center;
    font-size: 34px;
    margin-bottom: 40px;
    color: #3b1f1f;
}

.section-title span {
    color: #b84d4d;
}

/* ===============================
   ABOUT US
================================ */
.about-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    align-items: center;
}

.about-text h3 {
    font-size: 26px;
    margin-bottom: 15px;
    color: #3b1f1f;
}

.about-text p {
    margin-bottom: 15px;
    color: #555;
}

.about-points {
    margin-top: 20px;
}

.about-points li {
    list-style: none;
    margin-bottom: 10px;
    padding-left: 22px;
    position: relative;
}

.about-points li::before {
    content: "🍫";
    position: absolute;
    left: 0;
}

.about-image img {
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* ===============================
   CONTACT US
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

/* ===============================
   FOOTER
================================ */
.footer {
    background: #3b1f1f;
    color: #eee;
    text-align: center;
    padding: 18px 10px;
    margin-top: 60px;
}
</style>
</head>

<body>

<!-- ===============================
     ABOUT US
================================ -->
<section class="section">
    <div class="container">
        <h2 class="section-title">About <span>ChocoDelight</span></h2>

        <div class="about-wrapper">
            <div class="about-text">
                <h3>Crafting Happiness with Chocolate 🍫</h3>
                <p>
                    ChocoDelight is a premium chocolate brand dedicated to spreading joy
                    through rich flavors and handcrafted perfection.
                </p>
                <p>
                    We believe chocolate is not just a treat, but an experience that
                    connects emotions, celebrations, and memories.
                </p>

                <ul class="about-points">
                    <li>Premium quality ingredients</li>
                    <li>Freshly handcrafted chocolates</li>
                    <li>Perfect for gifting & celebrations</li>
                    <li>Made with love & passion</li>
                </ul>
            </div>

            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1548907040-4baa42d10919" alt="ChocoDelight Chocolate">
            </div>
        </div>
    </div>
</section>

<!-- ===============================
     CONTACT US
================================ -->
<section class="section" style="background:#fff;">
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
                <form>
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <textarea placeholder="Your Message"></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ===============================
     FOOTER
================================ -->
<footer class="footer">
    © 2025 ChocoDelight. All Rights Reserved.
</footer>

</body>
</html>
