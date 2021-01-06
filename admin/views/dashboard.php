<?php

/* Call for login function */

if(isset($_SESSION)){

include_once 'header.php'; 
include 'config/dbconnect.php';

    $ar_stmt = mysqli_query($conn,"SELECT * FROM articles");
    $articles = mysqli_num_rows($ar_stmt);
    $qt_stmt = mysqli_query($conn,"SELECT * FROM quotes");
    $quotes = mysqli_num_rows($qt_stmt);

?>
								

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-light" style="box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.459)">
              <div class="inner">
                <h3>
                    <?php echo htmlentities($articles);?>
                </h3>
                <p>Total Articles</p>
              </div>
               <a href="">
              <div class="icon">
                <i class="fa fa-book"></i>
              </div>
              <a class="small-box-footer"></i></a>
            </div>
          </div>


          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-light" style="box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.459)">
              <div class="inner">
                <h3>
                    <?php echo htmlentities($quotes);?>
                </h3>
                <p>Total Quotes</p>
              </div>
               <a href="">
              <div class="icon">
                <i class="fa fa-quote-left"></i>
              </div>
              <a class="small-box-footer"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
      
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <!-- AREA CHART -->
           
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cases</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-4">
            <!-- LINE CHART -->
              <!-- PIE CHART -->
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Resolved Vs Pending</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->     

            

          </div>
          <div class="col-md-4">
            <!-- LINE CHART -->
              <!-- PIE CHART -->
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Reported Vs Testimonials</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->     

            

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>

  <?php include_once 'footer.php'; ?>

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