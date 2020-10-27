<?php
	unset($_SESSION['flash_message']);
?>
	    <footer class="bg--dark footer-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <p>
                                <em>SR AGENCIES</em>
                            </p>
                            <ul class="footer__navigation">
                                <li>
                                    <a href="#">
                                        <span>Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-targ="about_us">
                                        <span>About Us</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-targ="contact_us">
                                        <span>Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-">
                            <div class="twitter-feed hide">
                                <div class="" data-feed-name="" data-amount="2">The Good Thing, Is Half Done</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-1 col-sm-12">
                            <h6>Subscribe</h6>
                            <p>
                                Get monthly updates and free resources.
                            </p>
                            <form class="form--merge form--no-labels" action="http://mrareco.createsend.com/t/d/s/kieth/" method="post" id="subForm" data-error="Please fill all fields correctly." data-success="Thanks for signing up! Please check your inbox for confirmation email.">
                                <p>
                                    <label for="fieldEmail">Email Address</label>
                                    <br />
                                    <input class="col-md-8 col-sm-6 validate-required validate-email" id="fieldEmail" name="cm-kieth-kieth" type="email" required />
                                </p>
                                <p>
                                    <button type="submit">Go</button>
                                </p>
                            </form>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
                <div class="footer__lower">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 text-center-xs">
                                <span class="type--fine-print">&copy; Copyright
                                    <span class="update-year">2019</span> SRA - All Rights Reserved</span>
                            </div>
                            <div class="col-sm-6 text-right text-center-xs">
                                <a href="#top" class="inner-link top-link">
                                    <i class="interface-up-open-big"></i>
                                </a>
                            </div>
                        </div>
                        <!--end of row-->
                    </div>
                    <!--end of container-->
                </div>
            </footer>
        </div>
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/isotope.min.js"></script>
        <script src="js/ytplayer.min.js"></script>
        <script src="js/easypiechart.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/lightbox.min.js"></script>
        <script src="js/twitterfetcher.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/scrollreveal.min.js"></script>
        <script src="js/parallax.js"></script>
        <script src="js/scripts.js"></script>


    <script>
  window.intercomSettings = {
    app_id: "jrdbn46n"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/jrdbn46n';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();

$(".menubar").click(function() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#"+$(this).data('targ')).offset().top
    }, 2000);
});

</script>
</body>

<!-- Mirrored from pillar.mediumra.re/home-business-classic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Aug 2019 11:53:56 GMT -->
</html>
