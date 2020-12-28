<?php

/* Call for login function */

if(isset($_SESSION)){

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
            <h1 class="m-0 text-dark">Quotes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quotes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
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
                <h3 class="card-title">New Quote</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form action="add_quote.php" id="uploadForm" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                <div class="card-body">

                        <label for="quote-image">Add Quote image (required)</label>
                        <div class="input-group">
                            <input type="file" name="quote_file" id="quote-image" class="form-control-file border" required>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button name="add_quote" id="mySubmit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div> 
    </section>
  </div>

  <?php include_once './views/footer.php'; ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function (e){
            $("#uploadForm").on('submit',(function(e){
                e.preventDefault();
                $.ajax({
                    url: "add_quote.php",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        $('input[name=quote_file]').val("");
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
  <?php 
  } 
  else {
    echo "
      <script>
     window.location.assign('../index.php');
    </script>
    ";
 
}
  ?>