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
            <h1 class="m-0 text-dark">Account Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Account Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
  
    </section>
  </div>

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
