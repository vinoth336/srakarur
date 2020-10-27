<?php 
	include("Header.php");
?>
<style>
	.masonry__filters ul li {
		font-weight:bold;
		color:#000;
	}
</style>
        <!--end of modal-container-->
        <div class="main-container transition--fade">
            <section class="height-100 imagebg cover cover-1 parallax" data-overlay="3">
                <div class="background-image-holder" style="background-color:#fff">
                    <img alt="image" src="img/banner1.jpg" />
                </div>
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-sm-6 text-right text-center-xs">
					<h2 style="margin-top:69px;margin-right:50px;letter-spacing:5px;">
						SR Agencies.
					</h2>
                        </div>
                        <div class="col-sm-6 text-center-xs">
                            <p class="lead">
				We offer a range of quality Toilet Paper products that provide practical and cost effective solutions for any washroom.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pos-absolute pos-bottom hidden-sm hidden-xs  <?php if(isset($_SESSION['sra_username'])){ echo 'hide'; } ?>">
                    <div class="row">
			    <section>
				<div class="container">
				    <div class="row">
					<div class="col-sm-8 col-sm-offset-6">
						<?php
							echo show_error();
						?>		
					    <form class="form--square text-center" action="portal/userlogin.php" method="post">
						<div class="input-with-icon col-sm-4">
						    <i class="icon-MaleFemale"></i>
						    <input class="validate-required" type="text" name="username" placeholder="User Name">
						</div>
						<div class="input-with-icon col-sm-4">
						    <i class="icon-Email"></i>
						    <input class="validate-required validate-email" type="password" name="password" placeholder="Password">
						</div>
						<div class="col-sm-2">
						    <button type="submit" class="btn btn--primary" name="login">
							Login	
						    </button>
						</div>
					    </form>
					</div>
				    </div>
				    <!--end of row-->
				</div>
				<!--end of container-->
			    </section>	
                    </div>
                </div>
            </section>

            <section class="space-bottom--sm" style="padding-top:1.5em;padding-bottom:0px">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h3>Our Products.</h3>
                            <p class="lead hide">
                            </p>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
	     <section class="wide-grid masonry masonry-shop">
                <div class="masonry__filters masonry__filters text-center" data-filter-all-text="Show All"></div>
                <div class="masonry__container masonry--animate">

			<?php 
				include("portal/LoadProduct.php");
				SetTemplates();	
			?>
                </div>
                <!--end masonry container-->
            </section>
	
	
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h3>Excellent Delivery Services</h3>
                            <p class="lead">
                                Our Company Providing The Excellent Delivery Service To OnTime Delivery The Items 
                            </p>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
            <section class="imagebg section--even stats-1 parallax" data-overlay="7">
                <div class="background-image-holder">
                    <img alt="image" src="img/hero2.jpg" />
                </div>
                <div class="row wide-grid">
                    <div class="col-sm-3 col-xs-6">
                        <div class="feature feature-1 text-center">
                            <i class="icon icon--lg icon-Bodybuilding"></i>
                            <h3>16,000+</h3>
                            <span>
                                <em>Customers strong</em>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="feature feature-1 text-center">
                            <i class="icon icon--lg icon-Fingerprint"></i>
                            <h3>16</h3>
                            <span>
                                <em>Delivery </em>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="feature feature-1 text-center">
                            <i class="icon icon--lg icon-Astronaut"></i>
                            <h3>82</h3>
                            <span>
                                <em>Launched startups</em>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="feature feature-1 text-center">
                            <i class="icon icon--lg icon-Cardigan"></i>
                            <h3>Zero</h3>
                            <span>
                                <em>Plaid cardigans</em>
                            </span>
                        </div>
                    </div>
                </div>
                <!--end of row-->
            </section>
	    <section class="testimonial testimonial-4 section--even bg--white">
                <div class="container">
                    <div class="row">
                        <div class="slider slider--controlsoutside" data-animation="fade" data-arrows="false" data-paging="true" data-timing="5000">
                            <ul class="slides">
                                <li>
                                    <div class="col-sm-10 col-sm-offset-1 text-center">
                                        <blockquote>
                                            &ldquo;I was a blown away by the design quality and sheer level of attention-to-detail, sweet!&rdquo;
                                        </blockquote>
                                        <h5>&mdash; Dan Gibon, Interface Designer</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-10 col-sm-offset-1 text-center">
                                        <blockquote>
                                            &ldquo;I've been using Medium Rare templates for a couple of years now - they're always highly polished and backed up by amazing support.&rdquo;
                                        </blockquote>
                                        <h5>&mdash; Sam Prichard, Interface Designer</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="col-sm-10 col-sm-offset-1 text-center">
                                        <blockquote>
                                            &ldquo;The design is fantastic, the builder saves me tons of time and the support has been excellent. I highly recommend Pillar.&rdquo;
                                        </blockquote>
                                        <h5>&mdash; Gale Adams, Envato Customer</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
            <section class="section--even bg--white" style="padding-top:1.5em;padding-bottom:0px" id="about_us">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h3>ABOUT US</h3>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
	   <section class="imageblock about-1 section--even bg--white">
                <div class="imageblock__content col-md-6 col-sm-4 pos-right">
                    <div class="background-image-holder" style="background: url(&quot;img/inner2.jpg&quot;); opacity: 1;">
                        <img alt="image" src="img/inner2.jpg">
                    </div>
                </div>
                <div class="container">
                    <div class="row">
			<div class="col-md-5 col-sm-8">
                            <h4>Expertise is just the beginning…</h4>
                            <p>
                                Strategy gamification alpha startup angel investor channels customer direct mailing burn rate churn rate bandwidth innovator seed round. Ramen disruptive graphical user interface.
                            </p>
                            <p>
                                Strategy gamification alpha startup angel investor channels customer direct mailing burn rate churn rate bandwidth innovator seed round. Ramen disruptive graphical user interface. Infrastructure bootstrapping branding leverage twitter channels MVP iPad launch party non-disclosure agreement.
                            </p>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>	
            <section  style="padding-top:1.5em;padding-bottom:0px" id="contact_us">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h3>CONTACT US</h3>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
	    <section class="features features-10">
                <div class="feature bg--white col-md-4 text-center">
                    <i class="icon icon--lg icon-Map-Marker2"></i>
                    <h4>Drop on in</h4>
                    <p>
                       	78A-2nd Floor, 
                        <br /> West Pradhakshnam Road, Bus Stand (opp), 
                        <br /> Karur - 639001 
                    </p>
                </div>
                <div class="feature bg--secondary col-md-4 text-center">
                    <i class="icon icon--lg icon-Phone-2"></i>
                    <h4>Give us a call</h4>
                    <p>
                        Office: <a href="tel:+919159713509">(+91) 91597 13509</a>
                        <br /> Mobile :  <a href="tel:+919159713509">(+91) 90877 71177</a>
                    </p>
                </div>
                <div class="feature bg--dark col-md-4 text-center">
                    <i class="icon icon--lg icon-Computer"></i>
                    <h4>Connect online</h4>
                    <p>
                        Email:
                        <a href="mailto:srakarur@gmail.com">srakarur@gmail.com</a>,<br>
                        <a href="mailto:sriraghavendraagencieskarur@gmail.com">sriraghavendraagencieskarur@gmail.com</a>,
			
                    </p>
                </div>
            </section>
	
		
            <section class="bg--primary space--sm cta cta-5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h4>Are You Interested ?</h4>
				<p class="lead">
                                   Let Fill Up This Form, We Contact You Shortly..... 
				</p>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
	    <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form class="form--square form-email" data-success="Thanks for your enquiry, we'll be in touch soon" data-error="Please fill all required fields" novalidate="true">
                                <div class="input-with-icon col-sm-12">
                                    <i class="icon-MaleFemale"></i>
                                    <input class="validate-required" type="text" name="name" placeholder="Your Name">
                                </div>
                                <div class="input-with-icon col-sm-6">
                                    <i class="icon-Email"></i>
                                    <input class="validate-required validate-email" type="email" name="email" placeholder="Email Address">
                                </div>
                                <div class="input-with-icon col-sm-6">
                                    <i class="icon-Phone-2"></i>
                                    <input type="tel" name="telephone" placeholder="Phone Number">
                                </div>
                                <div class="col-sm-12">
                                    <textarea class="validate-required" name="message" placeholder="Your Message" rows="8"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--primary">
                                        Submit Form
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>	
<?php
	include("Footer.php");
?>


