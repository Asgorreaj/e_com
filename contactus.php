<?php
// session_start চেক
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// functions.php include
if (!function_exists('getUserIp')) {
    include("includes/db.php");
    include("functions/functions.php");
} else {
    include("includes/db.php");
}
?>
<?php include("header.php"); ?>

<style>
/* ============================================
   CONTACT PAGE - MODERN DESIGN
   ============================================ */
.contact-wrapper {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}

/* Contact Info */
.contact-info {
    background: #fff;
    border-radius: 16px;
    padding: 35px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.contact-info h2 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.contact-info .subtitle {
    color: #6c757d;
    font-size: 15px;
    margin-bottom: 25px;
}

.contact-info .info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f2f6;
}

.contact-info .info-item:last-child {
    border-bottom: none;
}

.contact-info .info-item .icon {
    width: 45px;
    height: 45px;
    min-width: 45px;
    border-radius: 50%;
    background: rgba(255,82,59,0.08);
    color: #ff523b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.contact-info .info-item .content h4 {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.contact-info .info-item .content p {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
}

.contact-info .social-links {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.contact-info .social-links a {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #f8f9fa;
    color: #2d3436;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 18px;
}

.contact-info .social-links a:hover {
    background: #ff523b;
    color: #fff;
    transform: translateY(-3px);
}

/* Contact Form */
.contact-form {
    background: #fff;
    border-radius: 16px;
    padding: 35px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.contact-form h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.contact-form .subtitle {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 25px;
}

.contact-form .form-group {
    margin-bottom: 18px;
}

.contact-form .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 5px;
}

.contact-form .form-group label .required {
    color: #ff523b;
}

.contact-form .form-group input,
.contact-form .form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
    color: #2d3436;
}

.contact-form .form-group input:focus,
.contact-form .form-group textarea:focus {
    border-color: #ff523b;
    background: #fff;
    outline: none;
    box-shadow: 0 0 0 4px rgba(255,82,59,0.08);
}

.contact-form .form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.contact-form .submit-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ff523b, #ff6b5a);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.contact-form .submit-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(255,82,59,0.25);
}

.contact-form .submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Success Message */
.success-message {
    background: #00b894;
    color: #fff;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: none;
    align-items: center;
    gap: 12px;
}

.success-message.show {
    display: flex;
}

/* Breadcrumb */
.breadcrumb-custom {
    background: #f8f9fa;
    padding: 12px 20px;
    border-radius: 8px;
    max-width: 1200px;
    margin: 20px auto 0;
}

.breadcrumb-custom span {
    color: #6c757d;
    font-size: 14px;
}

.breadcrumb-custom a {
    color: #ff523b;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .contact-info {
        padding: 25px 20px;
    }
    .contact-form {
        padding: 25px 20px;
    }
    .contact-info h2 {
        font-size: 24px;
    }
    .contact-form h2 {
        font-size: 22px;
    }
}

@media (max-width: 480px) {
    .contact-wrapper {
        padding: 0 12px;
    }
    .contact-info {
        padding: 20px 15px;
    }
    .contact-form {
        padding: 20px 15px;
    }
    .contact-info .info-item {
        padding: 12px 0;
    }
    .contact-info .info-item .icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        font-size: 15px;
    }
}
</style>

<!-- ============================================
BREADCRUMB
============================================ -->
<div class="breadcrumb-custom">
    <a href="index.php">Home</a> / <span>Contact Us</span>
</div>

<!-- ============================================
CONTACT SECTION
============================================ -->
<section class="contact-wrapper">
    <div class="contact-grid">
        
        <!-- Contact Info -->
        <div class="contact-info">
            <h2>📬 Get in Touch</h2>
            <p class="subtitle">We'd love to hear from you! Reach out to us anytime.</p>
            
            <div class="info-item">
                <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="content">
                    <h4>Our Location</h4>
                    <p>123 Shopixia Street, London, UK</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="icon"><i class="fas fa-phone"></i></div>
                <div class="content">
                    <h4>Phone Number</h4>
                    <p>+44 1234 567890</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <div class="content">
                    <h4>Email Address</h4>
                    <p>support@shopixia.com</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="icon"><i class="fas fa-clock"></i></div>
                <div class="content">
                    <h4>Working Hours</h4>
                    <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                </div>
            </div>
            
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form">
            <h2>✉️ Send Us a Message</h2>
            <p class="subtitle">Fill out the form below and we'll get back to you within 24 hours.</p>
            
            <div class="success-message" id="successMsg">
                <i class="fas fa-check-circle"></i>
                <span>Your message has been sent successfully!</span>
            </div>
            
            <form action="contactus.php" method="post" id="contactForm">
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label>Subject <span class="required">*</span></label>
                    <input type="text" name="subject" placeholder="What is this about?" required>
                </div>
                
                <div class="form-group">
                    <label>Message <span class="required">*</span></label>
                    <textarea name="message" placeholder="Write your message here..." required></textarea>
                </div>
                
                <button type="submit" name="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ============================================
FOOTER
============================================ -->
<?php include("includes/footer.php"); ?>

<script>
// ============================================
// CONTACT FORM HANDLING
// ============================================
$(document).ready(function() {
    $('#contactForm').submit(function(e) {
        var btn = $(this).find('.submit-btn');
        var originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
        
        // Form submission handled by PHP
        // Just show loading state
        setTimeout(function() {
            btn.html(originalText).prop('disabled', false);
        }, 3000);
    });
});

// Show success message if form submitted
<?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
$(document).ready(function() {
    $('#successMsg').addClass('show');
    setTimeout(function() {
        $('#successMsg').removeClass('show');
    }, 5000);
});
<?php endif; ?>
</script>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $senderName = mysqli_real_escape_string($con, $_POST['name']);
    $senderEmail = mysqli_real_escape_string($con, $_POST['email']);
    $senderSubject = mysqli_real_escape_string($con, $_POST['subject']);
    $senderMessage = mysqli_real_escape_string($con, $_POST['message']);
    
    // Validate email
    if(!filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address');</script>";
    } else {
        // Send email to admin
        $to = "rakeshalakh@gmail.com";
        $subject = "Contact Form: " . $senderSubject;
        $message = "Name: " . $senderName . "\n";
        $message .= "Email: " . $senderEmail . "\n";
        $message .= "Subject: " . $senderSubject . "\n\n";
        $message .= "Message:\n" . $senderMessage;
        $headers = "From: " . $senderEmail . "\r\n";
        $headers .= "Reply-To: " . $senderEmail . "\r\n";
        
        if(mail($to, $subject, $message, $headers)) {
            // Auto-reply to customer
            $reply_subject = "Thank you for contacting Shopixia";
            $reply_message = "Dear " . $senderName . ",\n\n";
            $reply_message .= "Thank you for contacting us. We have received your message and will get back to you within 24 hours.\n\n";
            $reply_message .= "Best regards,\nShopixia Team";
            $reply_headers = "From: support@shopixia.com\r\n";
            
            mail($senderEmail, $reply_subject, $reply_message, $reply_headers);
            
            echo "<script>
                document.getElementById('successMsg').classList.add('show');
                document.getElementById('contactForm').reset();
                setTimeout(function() {
                    document.getElementById('successMsg').classList.remove('show');
                }, 5000);
            </script>";
        } else {
            echo "<script>alert('Sorry, there was an error sending your message. Please try again.');</script>";
        }
    }
}
?>