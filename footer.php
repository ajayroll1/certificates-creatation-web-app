<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3><?php echo isset($siteNameShort) ? $siteNameShort : 'ICBWO'; ?></h3>
            <p><?php echo isset($siteName) ? $siteName : 'International Certificate Board of World Organization'; ?></p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #cec0fc;">Global Certification Authority</p>
        </div>
        <div class="footer-section">
            <h3>Categories</h3>
            <ul>
                <li><a href="#">Web Development</a></li>
                <li><a href="#">Data Science</a></li>
                <li><a href="#">Design</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Marketing</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Company</h3>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Support</h3>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php echo isset($siteNameShort) ? $siteNameShort : 'ICBWO'; ?>. All rights reserved.</p>
    </div>
</footer>

