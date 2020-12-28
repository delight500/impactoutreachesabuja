<?php

/* Call for login function */

if (isset($_SESSION)) {

    include_once './views/header.php';
    include 'config/dbconnect.php';
    ?>
								

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Testimonials</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Testimonials</li>
            </ol>
          </div><!-- /.col -->
           <div class="container-fluid">
       
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
          
          <!-- If there is an error it will be shown. --> 
      <?php if (!empty($_SESSION['message'])): ?>
               <center>
              <div class="alert alert-danger alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong> <?php echo htmlentities(
                  $_SESSION['message']
              ); ?>.
            </div>
              </center>
      </div>
      <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
            <!-- If user account is created. -->
            <?php if (!empty($_SESSION['SuccessMessage'])): ?>
              <center>
              <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success!</strong> <?php echo htmlentities(
                  $_SESSION['SuccessMessage']
              ); ?>.
            </div>
              </center>
                    <?php unset($_SESSION['SuccessMessage']); ?>
      <?php endif; ?>
      
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-info" id="myform">
              <div class="card-header">
                <h3 class="card-title">New Article</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="add_testimonial.php" role="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="article-title">Testifiers Name</label>
                    <input type="text" class="form-control" id="article-title" name="t_name" placeholder="Enter Name" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="article-title">Testifiers Email (optional)</label>
                    <input type="text" class="form-control" id="article-title" name="t_email" placeholder="Enter Name" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="article-title">Testimony Title</label>
                    <input type="text" class="form-control" id="article-title" name="t_title" placeholder="Enter Title" autocomplete="off" required>
                  </div>  
                  <div class="form-group">
                    <label for="article-body">Testimony Description</label>
                    <textarea type="text" class="form-control" rows="7" name="t_desc" id="article-body" placeholder="Testimony Description" required>
                    </textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer">
                  <button type="submit" name="add_testimony" class="btn btn-primary" id="addarticle">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>  
    </section>
  </div>
<!-- <script>
            $.ajax({
               url: 'index.php',
               method: 'POST',
               dataType: 'text',
               data: {
                   add_article: 1,
                   data: 
               }, success: function (response) {
                    console.log(response);
               }
            });
</script> -->
<script>
  document.getElementById("article-body").innerHTML=""
  
</script>

  <?php include_once './views/footer.php'; ?>

  <?php
} else {
    echo "
      <script>
     window.location.assign('../index.php');
    </script>
    ";
}
?>
