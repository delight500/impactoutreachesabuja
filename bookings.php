<?php include 'includes/handler.php'; ?>
<?php include 'includes/header.php'; ?>

  <section class="hero-wrap hero-wrap-2" style=" background-image: url('components/img/impact/team1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Bookings<i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">Bookings</h1>
          </div>
        </div>
      </div>
    </section>

    <div class="jumbotron bg-light">
       <div class="container" >
      	<div class="row">
      		<div class="col-md-2">
      			<img src="components/img/impact/new_rev.jpg" style="height:150px; width:120px" class="img-fluid ">
      		</div>
      		<div class="col-md-8">
      			<div class="about-text float-right">
      				<p class="intro">You can now invite Reverend Ifeoluwa Onitiri as your guest for your programs,church events, seminars and conferences just by simply booking here.
      				</p>

      				<strong>Contact the president directly</strong>
      				<br>
      				<span class="fa fa-dot-circle-o"></span>
      				<strong>Email:</strong> -  rev.ifeoluwa@impactoutreachesabuja.org.ng <br>
      				<span class="fa fa-dot-circle-o"></span>
      				<strong>Phone:</strong> -  +234 8179836255, +234 8062942715<br>
      				<br>
      				</ul>
					  <hr style="border-width: 1px; width: 100%; background-color: black;">
					  <br>
      			
      		
				<form action="bookings.php" role="form" autocomplete="on" id="myForm" method="POST" enctype="multipart/form-data">

					<div class="form-inline"> 
						<div class="input-group mb-3 input-group-sm form-inline" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Name</span>
							</div>
							<input type="text" class="form-control" name="b_fname" required>
						</div>
						
						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Surname</span>
							</div>
							<input type="text" class="form-control" name="b_sname" required>
						</div>

						<div class="input-group mb-3 input-group-sm" >
							<div class="input-group-prepend">
							<span class="input-group-text">State</span>
							</div>
							<select name="b_state" class="form-control">
								<option value="Abia">Abia</option>
								<option value="Adamawa">Adamawa</option>
								<option value="Anambra">Anambra</option>
								<option value="Akwa Ibom">Akwa Ibom</option>
								<option value="Bauchi">Bauchi</option>
								<option value="Bayelsa">Bayelsa</option>
								<option value="Benue">Benue</option>
								<option value="Borno">Borno</option>
								<option value="Cross River">Cross River</option>
								<option value="Delta">Delta</option>
								<option value="Ebonyi">Ebonyi</option>
								<option value="Enugu">Enugu</option>
								<option value="Edo">Edo</option>
								<option value="Ekiti">Ekiti</option>
								<option value="FCT - Abuja">FCT - Abuja</option>
								<option value="Gombe">Gombe</option>
								<option value="Imo">Imo</option>
								<option value="Jigawa">Jigawa</option>
								<option value="Kaduna">Kaduna</option>
								<option value="Kano">Kano</option>
								<option value="Katsina">Katsina</option>
								<option value="Kebbi">Kebbi</option>
								<option value="Kogi">Kogi</option>
								<option value="Kwara">Kwara</option>
								<option value="Lagos">Lagos</option>
								<option value="Nasarawa">Nasarawa</option>
								<option value="Niger">Niger</option>
								<option value="Ogun">Ogun</option>
								<option value="Ondo">Ondo</option>
								<option value="Osun">Osun</option>
								<option value="Oyo">Oyo</option>
								<option value="Plateau">Plateau</option>
								<option value="Rivers">Rivers</option>
								<option value="Sokoto">Sokoto</option>
								<option value="Taraba">Taraba</option>
								<option value="Yobe">Yobe</option>
								<option value="Zamfara">Zamfara</option>
							</select>
						</div>
					
					</div>	
						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Phone number</span>
							</div>
							<input type="tel" class="form-control" name="b_pnumber" required>
						</div>
						
						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Country</span>
							</div>
							<input type="text" class="form-control" name="b_country" required>
						</div>

						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Name of organization/church</span>
							</div>
							<input type="text" class="form-control" name="b_Cname" required>
						</div>	

						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Email</span>
							</div>
							<input type="email" class="form-control" name="b_email" required>
						</div>	

						<div class="input-group mb-3 input-group-sm" style="padding-right: 10px;">
							<div class="input-group-prepend">
							<span class="input-group-text">Address</span>
							</div>
							<input type="text" class="form-control" name="b_address" required>
						</div>
						
							<span class="input-group-text">Purpose</span>

							<br>
						<input type="radio" id="age1" name="b_purpose" value="I want to collaborate with impact outreaches Abuja for a program">
						<label for="age1">I want to collaborate with impact outreaches Abuja for a program</label><br>
						<input type="radio" id="age2" name="b_purpose" value="I want to be mentored by the Reverend">
						<label for="age2">I want to be mentored by the Reverend</label><br>  
						<input type="radio" id="age3" name="b_purpose" value="My ministry needs financial assistance">
						<label for="age3">My ministry needs financial assistance</label><br><br>

							<br>

						<div class="form-group">
							<span class="input-group-text">Explain the selected option </span>
							<textarea class="form-control" rows="6" name="b_desc" required></textarea>
						</div>

						<button name="booking" type="submit" class="btn btn-success">Submit</button>

				</form>
			

      			</div>
      		</div>
      	</div>
      </div>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
 $(document).ready(function (){
		$("#myForm").on('submit',(function(e){
			e.preventDefault();
			const rbs = document.querySelectorAll('input[name="b_purpose"]');
			let selectedValue;
            for (const rb of rbs) {
                if (rb.checked) {
          
					$.ajax({
						url: "bookings.php",
						type: "POST",
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success: function(data){
							$('input:radio').attr("checked" , false );
							$('input[name=b_fname]').val("");
							$('input[name=b_sname]').val("");
							$('input[name=b_state]').val("");
							$('input[name=b_pnumber]').val("");
							$('input[name=b_country]').val("");
							$('input[name=b_Cname]').val("");
							$('input[name=b_email]').val("");
							$('input[name=b_address]').val("");
							$('textarea[name=b_desc]').val("");

							var json = JSON.parse(data);
							var heading1 = json["heading1"];
							var message = json["message"];
							var heading2 = json["heading2"];
							swal(`${heading1}`,`${message}`, `${heading2}`);
						},
						error: function(){}
					});
		}else{
			swal("Error", "Please select at least one purpose", "error");
		}}
		}));
	});
</script>
