<?php

/* Call for login function */
if (isset($_SESSION)) {
    include_once './views/header.php';
    include 'config/dbconnect.php';
    ?>
								

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bookings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bookings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   
   <div class="card ">
            <div class="card-header">
              <h3 class="card-title">View Appointments</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive-sm">
                          <table class="table table-striped table-advance table-hover" id="example1" >
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Phone Number</th>
                  <th>Purpose</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->prepare(
                    'SELECT * FROM `bookings` ORDER BY `id` DESC'
                );
                $stmt->execute();
                $cnt = 1;
                $result = $stmt->get_result();

                while ($row = mysqli_fetch_array($result)) { 
                    
                 $ustatus ="<a href='javascript:;' onClick='pickRow(" . json_encode($row) .")' 
                                data-toggle='modal' data-target='#dataModal' class='btn btn-primary btn-sm' id='viewbtn' style='width:100%'>view
                                </a>";
                echo "<tr>
                                <td>".$cnt."</td>
                                <td>".$row['bf_name']." ".$row['bs_name']."</td>
                                <td>".$row['b_pnumber']."</td>                               
                                <td>".$row['b_purposet']."</td>
                                <td>".$row['status']."</td>                                
                                <td>".$row['date']."</td>
                            
                                <td>".$ustatus."</td>
                                
                </tr>";
                 $cnt = $cnt + 1;
                }
                ?>
              
                  
                
                </tbody>
                <tfoot>
                 <tr>
                                

                    <th>S/N</th>
                  <th>Name</th>
                  <th>Phone Number</th>
                  <th>Purpose</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>

                <!-- The Modal -->
                <div class="modal fade" id="dataModal">
                    <div class="modal-dialog ">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Appointment request Details</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-text-width"></i>

                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <dl class="row">
                                            <dt class="col-sm-4">Name:</dt>
                                            <dd class="col-sm-8" id="b_name"></dd>
                                            <dt class="col-sm-4">State:</dt>
                                            <dd class="col-sm-8" id="b_state"></dd>
                                            <dt class="col-sm-4">Phone Number:</dt>
                                            <dd class="col-sm-8" id="b_number"></dd>
                                            <dt class="col-sm-4">Country:</dt>
                                            <dd class="col-sm-8" id="b_country"></dd>
                                            <dt class="col-sm-4">Email:</dt>
                                            <dd class="col-sm-8" id="b_email"></dd>
                                            <dt class="col-sm-4">Org Name:</dt>
                                            <dd class="col-sm-8" id="b_cname"></dd>
                                            <dt class="col-sm-4">Address</dt>
                                            <dd class="col-sm-8" id="b_address"></dd>
                                            <dt class="col-sm-4">Purpose</dt>
                                            <dd class="col-sm-8" id="b_purpose"></dd>
                                            <dt class="col-sm-4"> Description:</dt>
                                            <dd class="col-sm-8" id="b_purposedesc"></dd>
                                            <dt class="col-sm-4">Status:</dt>
                                            <dd class="col-sm-8" id="b_status"></dd>
                                            <dt class="col-sm-4">Date:</dt>
                                            <dd class="col-sm-8" id="b_date"></dd>

                                        </dl>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>



                </div>
            </div>
            <!-- /.card-body -->


  <?php include_once './views/footer.php'; ?>
    <script>
        $(function () {
            $("#example1").DataTable();
        });


        
    function pickRow(res){
        console.log(res);
        $('#b_name').html(res.bf_name + "  " + res.bs_name);
        $('#b_state').html(res.b_state);
        $('#b_number').html(res.b_pnumber);
        $('#b_country').html(res.b_country);
        $('#b_email').html(res.b_email);
        $('#b_cname').html(res.b_Cname);
        $('#b_address').html(res.b_address);
        $('#b_purpose').html(res.b_purposet);
        $('#b_purposedesc').html(res.b_purposedesc);
        $('#b_status').html(res.status);
        $('#b_date').html(res.date);
        $('#dataModal').modal("show");
    }
                   



</script>

  <?php
} else {
    echo "
      <script>
     window.location.assign('../index.php');
    </script>
    ";
}
?>
