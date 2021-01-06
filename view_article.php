
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
				        			

                <?php 
                $id = $_GET['id'];
                
                $stmt = $conn->prepare(
                  'SELECT * FROM `articles` WHERE id= ? '
                );
                 $stmt->bind_param('s', $id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = mysqli_fetch_array($result)) { 
               
                ?>
                <div class="card">
                <div class="card-header">
                    <h5><?php echo $row['title']; ?> <p style="float: right;"><?php echo $row['date']; ?></p></h5></div>
                <div class="card-body">
                <div class="container">
                    <div class="row">
                    <div class="col-6">
                    <center ><img  src="<?php echo"admin/".$row['featured_image']; ?>" style="width:400px; height:300px" alt="" ></center>
                    </div>
                    <div class="col-6">
                    <center ><h4><?php echo $row['title']; ?></h4>
                    <hr>
                   
                    </center>
                     <p>
                        <?php echo $row['description']; ?>
                    </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="card-footer"><a href="articles.php" class="btn btn-success float-right">Back</a></div>
                </div>
	<?php  } ?>	

    
      		</div>
      	</section>
   
    

  <br>
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
