
    <!-- Navigation -->
   <?php include('includes/header.php');
   include("admin/config/dbconnect.php")?>
   <section class="hero-wrap hero-wrap-2" style=" background-image: url('components/img/impact/articles1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Articles <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">life transforming messages!</h1>
          </div>
        </div>
      </div>
	</section>
<br>
            <header class="section-header">
      				<h3 class="section-title" style="font-size: 20px;">Latest Articles from the man of God</h3>
      			</header>


      <section id="portfolio" class="section-bg">
      		<div class="container"> 
				        			<div class="row portfolio-container">

				<?php
                $stmt = $conn->prepare(
                    'SELECT * FROM `articles` ORDER BY `id` DESC '
                );
                $stmt->execute();
                $cnt = 1;
                $result = $stmt->get_result();

                while ($row = mysqli_fetch_array($result)) { 
               
				?>
				    <div class="col-lg-3 col-md-6 portfolio-item filter-app wow fadeInUp">
      					<div class="portfolio-wrap">
      						<figure>
      							<img src="<?php echo "admin/".$row['featured_image']; ?>" class="img-fluid" alt="">
      							<a href="<?php echo "admin/".$row['featured_image']; ?>" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
      							<a href="view_articles.php?id=<?php echo $row['id']; ?>" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
      						</figure>

      						<div class="portfolio-info">
      							<h4><a href="view_article.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h4>
      							<p><?php echo $row['date']; ?></p>
      						</div>
      					</div>
              		</div>
			
      			
      			<?php  } ?>	

              	
      			</div>

      		</div>
      	</section>
   
    

  <br>
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
