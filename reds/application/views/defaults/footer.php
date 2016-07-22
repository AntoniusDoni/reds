<footer>
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="separator middle footer-separator"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="footer-widget">
                    <div class="widget-title">
                        <h2>Information</h2>
                    </div>
                    <div class="widget-content">
                        <ul class="links">
                            <li><a href="#">New Products</a></li>
                            <li><a href="#">Top Sellers</a></li>
                            <li><a href="#">Specials</a></li>
                            <li><a href="#">Manufacturers</a></li>
                            <li><a href="#">Suppliers</a></li>
                            <li><a href="#">Our Stores</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-widget">
                    <div class="widget-title">
                        <h2>My Account</h2>
                    </div>
                    <div class="widget-content">
                        <ul class="links">
                            <li><a href="#">New Products</a></li>
                            <li><a href="#">Top Sellers</a></li>
                            <li><a href="#">Specials</a></li>
                            <li><a href="#">Manufacturers</a></li>
                            <li><a href="#">Suppliers</a></li>
                            <li><a href="#">Our Stores</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-widget">
                    <div class="widget-title">
                        <h2>Customer Service</h2>
                    </div>
                    <div class="widget-content">
                        <ul class="links">
                            <li><a href="#">New Products</a></li>
                            <li><a href="#">Top Sellers</a></li>
                            <li><a href="#">Specials</a></li>
                            <li><a href="#">Manufacturers</a></li>
                            <li><a href="#">Suppliers</a></li>
                            <li><a href="#">Our Stores</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-widget">
                    <div class="widget-title">
                        <h2>Contact Info</h2>
                    </div>
                    <div class="widget-content">
                        <address>
                            <?= $this->modelsetting->getDetailSetting(1)->address; ?></br>
                            Phone : <?= $this->modelsetting->getDetailSetting(1)->tlp; ?></br>
                            Email : <?= $this->modelsetting->getDetailSetting(1)->emails; ?>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="separator footer-separator">
                    <button class='scroll-top'>Scroll top</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="copyright">
                    <p>&copy; 2013. Developed by <a href="http://gamaka.com">be Admin</a>&trade;. All Rights Reserved.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="social-links">
                    <ul>
                        <li><a href="#" class="facebook">facebook</a></li>
                        <li><a href="#" class="twitter">twitter</a></li>
                        <li><a href="#" class="email">email</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    function addtocart(url) {
        $(document).ready(function() {
            document.location.href = "<?= base_url() ?>detailproduct/" + url;
        });
    }
    $('.scroll-top').on('click', scrollTop);
</script>

</body>
</html>