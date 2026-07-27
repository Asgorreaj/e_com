<!-- footer section starts -->
<style>
/* ===== FOOTER BASE STYLES ===== */
.footer {
    background-color: #0d2b38;
    color: #ffffff;
    padding: 60px 0 20px 0;
    font-family: inherit;
    border-top: 3px solid #ff523b;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
}

.footer-col {
    flex: 1 1 200px;
    min-width: 200px;
}

.footer-col h4 {
    font-size: 16px;
    color: #ffffff;
    text-transform: uppercase;
    margin-bottom: 20px;
    font-weight: 700;
    position: relative;
    padding-bottom: 10px;
    letter-spacing: 0.5px;
}

/* Heading Underline Effect */
.footer-col h4::before {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    background-color: #ff523b;
    height: 2px;
    width: 40px;
    border-radius: 2px;
}

.footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-col ul li {
    margin-bottom: 12px;
}

.footer-col ul li a {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    text-transform: capitalize;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-col ul li a:hover {
    color: #ff523b;
    padding-left: 6px;
}

/* Social Media Links */
.footer-col .social-links {
    display: flex;
    gap: 12px;
    align-items: center;
}

.footer-col .social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-col .social-links a i {
    font-size: 16px;
    transition: all 0.3s ease;
}

.footer-col .social-links a:hover {
    background: #ff523b;
    transform: translateY(-3px);
}

.footer-col .social-links a:hover i {
    color: #ffffff !important; /* Overrides inline icon colors on hover */
}

/* Payment Icons or Extra Section */
.footer-payments {
    margin-top: 15px;
}

.footer-payments span {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.5);
    display: block;
    margin-bottom: 8px;
}

/* Footer Bottom Credit */
.footer-bottom {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    text-align: center;
}

.footer-bottom .credit {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

.footer-bottom .credit span {
    color: #fdcb6e;
    font-weight: 600;
}

.footer-bottom .credit span.brand-name {
    color: #ff523b;
}

/* ===== MOBILE & TABLET RESPONSIVE ===== */
@media (max-width: 768px) {
    .footer {
        padding: 40px 0 20px 0;
    }

    .footer-row {
        gap: 25px;
    }

    .footer-col {
        flex: 1 1 100%; /* Mobile - 1 column layout */
        text-align: center;
    }

    .footer-col h4::before {
        left: 50%;
        transform: translateX(-50%);
    }

    .footer-col ul li a:hover {
        padding-left: 0;
    }

    .footer-col .social-links {
        justify-content: center;
    }
}

@media (min-width: 480px) and (max-width: 768px) {
    .footer-col {
        flex: 1 1 45%; /* Tablet - 2 column layout */
        text-align: left;
    }

    .footer-col h4::before {
        left: 0;
        transform: none;
    }

    .footer-col .social-links {
        justify-content: flex-start;
    }
}
</style>

<footer class="footer" id="footer">
    <div class="footer-container">
        <div class="footer-row">
            
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Affiliate Program</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Get Help</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Order Status</a></li>
                    <li><a href="#">Payment Options</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Online Shop</h4>
                <ul>
                    <li><a href="#">Saloon Products</a></li>
                    <li><a href="#">Parlor Products</a></li>
                    <li><a href="#">Garments</a></li>
                    <li><a href="#">Others</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f" style="color: #3b5998;"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter" style="color: #0084b4;"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram" style="color: #E1306C;"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in" style="color: #0077B5;"></i></a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p class="credit">
                Copyright &copy; <span>2026</span> | All Rights Reserved | 
                <span class="brand-name">Shopixia - Multi Vendor Ecommerce Platform</span>
            </p>
        </div>
    </div>
</footer>
<!-- footer section ends -->