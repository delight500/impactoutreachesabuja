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
            <h1 class="m-0 text-dark">Testimonials</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Testimonials</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
  <div class="card ">
            <div class="card-header">
              <h3 class="card-title">View Testimonial</h3>
               <a class="btn btn-primary btn-sm" style="float: right;" href="add_testimonial.php">
                              <i class="fa fa-plus-square">
                              </i>
                              Add Testimonial
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                  <th>Featured image</th>
                  <th>Title</th>
                  <th>Article body</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                
                <tr>
                  <td>Misc</td>
                  <td>PSP browser</td>
                  <td>PSP</td>
                  <td>PSP</td>
                 <td class="project-actions ">
                              <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>                      </td>
                </tr>
                <tr>
                  <td>Other browsers</td>
                  <td>All others</td>
                  <td>-</td>
                  <td>PSP</td>
                <td class="project-actions ">
                             <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                      </td>
                </tr>
                </tbody>
                <tfoot>
                 <tr>
                   <th>Featured image</th>
                  <th>Title</th>
                  <th>Article body</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </section>
  </div>

  <?php include_once './views/footer.php'; ?>

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