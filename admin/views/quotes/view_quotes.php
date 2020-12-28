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
  <div class="card ">
            <div class="card-header">
              <h3 class="card-title">View Quotes</h3>
               <a class="btn btn-primary btn-sm" style="float: right;" href="add_quote.php">
                              <i class="fa fa-plus-square">
                              </i>
                              Add Quote
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                           <table id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>S/N</th>
                  <th>Quote image</th>
                  <th>Posting date</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->prepare(
                    'SELECT * FROM `quotes` ORDER BY `id` DESC'
                );
                $stmt->execute();
                $cnt = 1;
                $result = $stmt->get_result();

                while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><img src=<?php echo $row['image']; ?> alt="img" style="height: 60px; width: 60px"></td>
                    <td><?php echo $row['date']; ?></td>

                   <td class="project-actions ">
                       <button class="btn btn-primary btn-sm ar_data" id="<?php echo $row["id"]; ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </button>

                       <a class="btn btn-danger btn-sm" href="view_quotes.php?qid=<?php echo $row['id'];?>"  onClick=" return confirm('Do you really want to delete');">
                           <i class="fas fa-trash">
                           </i>
                           Delete
                       </a>
                      </td>
                </tr>
                    <?php $cnt = $cnt + 1;}?>
                </tbody>
                <tfoot>
                 <tr>
                     <th>S/N</th>
                   <th>Quote image</th>
                  <th>Posting date</th>
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
                                <h4 class="modal-title">Quote Details</h4>
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
                                            <dt class="col-sm-4">Quote Image</dt>
                                            <dd class="col-sm-8" id="ar_img"></dd>
                                            <dt class="col-sm-4">Date posted</dt>
                                            <dd class="col-sm-8" id="ar_date"></dd>

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
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </section>
  </div>

  <?php include_once './views/footer.php'; ?>
    <script>

        $(document).ready(function(){
            $('.ar_data').click(function(){
                var leader_id = $(this).attr("id");
                $.ajax({
                    url:"view_quotes.php",
                    method:"post",
                    data:{view_quote:leader_id},
                    dataType: 'json',
                    success:function(res){
                        console.log(res);
                        $('#ar_date').html(res.date);
                        $('#ar_img').html(`<img src=${res.image} alt="img" style="height: 250px; width: 250px">`);
                        $('#dataModal').modal("show");
                    }
                });

            });
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