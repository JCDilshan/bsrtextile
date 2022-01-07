<!-- footer -->
<footer class="container-fluid mt-4 pb-2" style="background-color: #262626; min-height:150px; height:auto;">

    <div class="row">

        <div class="col-sm-6 col-lg-3 mt-2">
            <div class="row">
                <div class="col-12">
                    <p class="text-white font-weight-lighter">BE THE FIRST TO KNOW</p>
                </div>
                <div class="col-8 col-lg-12">
                    <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="col-8 mt-2">
                    <button type="submit" class="btn fbutton">SUBSCRIBES US</button>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 mt-2">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-white font-weight-lighter">FOLLOW US ON</h2>
                </div>
                <div class="col-12 d-flex">
                    <a href="https://www.facebook.com" class="pr-4 button1"><i class="fab fa-facebook-square " style="font-size: 48px"></i></a>
                    <a href="https://www.twitter.com" class="pr-4 button1"><i class="fab fa-twitter-square" style="font-size: 48px"></i></a>
                    <a href="https://www.instagram.com" class="pr-4 button1"><i class="fab fa-instagram-square" style="font-size: 48px"></i></a>
                    <a href="https://www.pinterest.com" class="pr-4 button1"><i class="fab fa-pinterest-square" style="font-size: 48px"></i></a>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 mt-2">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-white font-weight-lighter">CUSTOMER CARE</h2>
                </div>
                <div class="col-12">
                    <ul class="font-weight-lighter list-group list-unstyled">
                        <li><a href="#" class="text-decoration-none text-white">Return & Refund</a></li>
                        <li><a href="contactus.php" class="text-decoration-none text-white">Contact Us</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Service Payment</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Store Locator</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Size Guide</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 mt-2">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-white font-weight-lighter">DISCOVER</h2>
                </div>
                <div class="col-12">
                    <ul class="font-weight-lighter list-group list-unstyled">
                        <li><a href="aboutUs.php" class="text-decoration-none text-white">About Us</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Terms Of Use</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Service Payment</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-decoration-none text-white">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</footer>

<div class="w-100" style="height: 1px; background-color:white;"></div>

<!-- ////////////////////////// Copyright row start //////////////////////////////// -->
<footer class="container-fluid" style="background-color: #262626; min-height:70px; height:auto;">

    <div class="row pt-3 pb-2">

        <div class="col-md-6">
            <p class="text-white text-uppercase font-weight-lighter">
                Designed By JC Dilshan <br>
                Copyrights &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
                All rights reserved
            </p>
        </div>

        <div class="col-md-6">
            <img src="../image/payment_methord/master.png" alt="MASTER" width="65px" height="40px" style="border-radius: 5px">&nbsp;
            <img src="../image/payment_methord/visa.png" alt="VISA" width="65px" height="40px" style="border-radius: 5px">&nbsp;
            <img src="../image/payment_methord/genie.png" alt="GENIE" width="40px" height="40px">&nbsp;
            <img src="../image/payment_methord/sampth.png" alt="SAMPATH" width="40px" height="40px" style="border-radius: 10px">
            <img src="../image/payment_methord/commercial.jpg" alt="COMMERCIAL" width="40px" height="40px" style="border-radius: 10px">
            <img src="../image/payment_methord/fri-me.png" alt="FRIME" width="40px" height="40px" style="border-radius: 10px">
        </div>

    </div>

</footer>
<!-- ////////////////////////// Copyright row End //////////////////////////////// -->

<div style="height:8px; background-color: #db9200;"></div>

<script>
    $(document).ready(function() {

        $("#logoutBtn").on("click", function(e) {
            e.preventDefault();

            let url = $(this).attr("href");

            Swal.fire({
                title: "Are You sure You Want Logout ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "red",
                cancelButtonColor: "blue",
                confirmButtonText: "Yes Logout"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = url;
                }
            });

        });

    });
</script>
</body>

</html>