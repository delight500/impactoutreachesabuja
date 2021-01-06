
<?php /* Call for login function */

if (isset($_SESSION)) {
    include 'config/dbconnect.php'; ?>

	  <?php
   $ret = mysqli_query(
       $conn,
       "select * from testimonials where id='" . $_GET['id'] . "'"
   );
   while ($row = mysqli_fetch_array($ret)) { ?>		

<?php include_once './views/header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Testimonals</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Testimonals</li>
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
                <h3 class="card-title">Edit Testimonial</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <form action="edit_testimonial.php?id=<?php echo $row[
                  'id'
              ]; ?>" role="form" autocomplete="off" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="usr">Testifiers Name</label>
                        <textarea class="form-control" rows="1"  id="usr" name="t_name" required><?php echo $row[
                            'name'
                            ]; ?></textarea>

                    </div>
                  <div class="form-group">
                        <label for="usr">Testimony Title</label>
                        <textarea class="form-control" rows="1"  id="usr" name="t_title" required><?php echo $row[
                            'title'
                            ]; ?></textarea>

                    </div>

                  <div class="form-group">
      <label for="article-body">Testimony Body</label>
      <textarea class="form-control" rows="5"  id="article-body" name="t_desc"><?php echo $row[
          'description'
      ]; ?></textarea>
    </div>
          
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer">
                  <button type="submit" name="edit_article" class="btn btn-primary" id="addarticle">Update</button>
                </div>
          
              </form>
              <?php }
   ?>
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
