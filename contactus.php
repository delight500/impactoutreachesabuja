<?php include 'includes/config.php'; ?>
      <?php include 'includes/header.php'; ?>

	    <!--==========================
        Hero Section
      ============================-->
	  <section class="hero-wrap hero-wrap-2" style="background-image: url('components/img/impact/288.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact Us <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">Get in Touch with us!</h1>
          </div>
        </div>
      </div>
    </section>
  <!--==========================
        Contact Section
      ============================-->
      <section id="contact" class="section-bg wow fadeInUp">
      		<div class="container">

      			<div class="section-header">
      				<h3>Contact Us</h3>
      				<p>Send us an email !</p>
      			</div>

      		<div class="row contact-info">

      				<div class="col-md-4">
      					<div class="contact-address">
      						<i class="ion-ios-location-outline"></i>
      						<h3>Address</h3>
      						<address>Suite C 2Ekesons Plaza Plot 175 Utako District, Opposite MFM Church Utako, Abuja Nigeria.</address>
      					</div>
      				</div>

      				<div class="col-md-4">
      					<div class="contact-phone">
      						<i class="ion-ios-telephone-outline"></i>
      						<h3>Phone Number</h3>
      						<p><a href="tel:+155895548855">+234 8179836255
								  <br>
								  +234 8062942715</a></p>
      					</div>
      				</div>

      				<div class="col-md-4">
      					<div class="contact-email">
      						<i class="ion-ios-email-outline"></i>
      						<h3>Email</h3>
      						<p><a href="mailto:info@example.com">contact@impactoutreachesabuja.com.ng
<br>
							  bookings@impactoutreachesabuja.com.ng</a></p>
      					</div>
      				</div>

      			</div>

      			<div class="form">
      				<div id="sendmessage">Your message has been sent. Thank you!</div>
      				<div id="errormessage"></div>
      				<form action="contactus.php" id="myForm" method="post" role="form" class="contactForm">
      					<div class="form-row">
      						<div class="form-group col-md-6">
      							<input type="text" name="c_name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required/>
      							<div class="validation"></div>
      						</div>
      						<div class="form-group col-md-6">
      							<input type="email" class="form-control" name="c_email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
      							<div class="validation"></div>
      						</div>
						  </div>
						  <div class="form-row">
      					<div class="form-group col-md-6">
      						<input type="text" class="form-control" name="c_subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" required/>
      						<div class="validation"></div>
						  </div>
						  <div class="form-group col-md-6">
      						<input type="text" class="form-control" name="c_phone" id="number" placeholder="Phone number" data-rule="minlen:4" data-msg="Please enter your phone number" required/>
      						<div class="validation"></div>
						  </div>
						  </div>
      					<div class="form-group">
      						<textarea class="form-control" name="c_message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
      						<div class="validation"></div>
      					</div>
      					<div class="text-center"><button name="contactform" type="submit">Send Message</button></div>
      				</form>
      			</div>

      		</div>
		  </section><!-- #contact -->
		  	<!--==========================
        Call To Action Section
      ============================-->
	  <section id="call-to-action" class="wow fadeIn">
      		<div class="container text-center">
      			<h3> Become an Affiliate Member
      				or <br>Enjoy Financial Mentorship</h3>

      			<a class="cta-btn" href="bookings.php">Sign up</a>
      			<br>
      			<div>
      				<a style="color:white; padding-right:12px" target="_blank" rel="noopener noreferrer" href="https://web.facebook.com/impact.outreaches" onMouseOver="this.style.color='blue'"  
					onMouseOut="this.style.color='white'"><i class="ion-social-facebook" style="font-size:30px;"></i> </a>
      				<a style="color:white;" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/impactoutreachesabuj" data-placement="bottom" onMouseOver="this.style.color='blue'"
					  onMouseOut="this.style.color='white'"><i class="ion-social-instagram-outline" style="font-size:30px;padding-right:12px "></i></a>
      				<a style="color:white;" target="_blank" rel="noopener noreferrer" href="https://www.youtube.com" data-placement="bottom" onMouseOver="this.style.color='red'"
					  onMouseOut="this.style.color='white'"><i class="ion-social-youtube" style="font-size:30px;"></i></a>
      			</div>
      		</div>
      	</section><!-- #call-to-action -->
<br>
<br>

        <?php include 'includes/footer.php'; ?>
<script type="text/javascript">
 $(document).ready(function (){
		$("#myForm").on('submit',(function(e){
			e.preventDefault();          
			$.ajax({
				url: "components/mail/contact_me.php",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					$('input[name=c_name]').val("");
					$('input[name=c_email]').val("");
					$('input[name=c_subject]').val("");
					$('textarea[name=c_message]').val("");

					var json = JSON.parse(data);
					var heading1 = json["heading1"];
					var message = json["message"];
					var heading2 = json["heading2"];
					swal(`${heading1}`,`${message}`, `${heading2}`);
				},
				error: function(){}
			});
		}));
	});
</script>
