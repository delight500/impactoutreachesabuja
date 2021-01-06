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
            <h1 class="m-0 text-dark">Articles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Articles</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   
   <div class="card ">
            <div class="card-header">
              <h3 class="card-title">View articles</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive-sm">
                          <table class="table table-striped table-advance table-hover" id="example1" >
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Featured image</th>
                  <th>Title</th>
                  <th>Article body</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->prepare(
                    'SELECT * FROM `articles` ORDER BY `id` DESC'
                );
                $stmt->execute();
                $cnt = 1;
                $result = $stmt->get_result();

                while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                 <td><?php echo $cnt; ?></td>
                 <td><img src=<?php echo $row[
                     'featured_image'
                 ]; ?> alt="img" style="height: 60px; width: 60px"></td>
                  <td><?php echo $row['title']; ?></td>
                  <td><?php echo $row['description']; ?></td>
                   <td><?php echo $row['date']; ?></td>
                 <td class="project-actions ">
                     <input type="button" name="view" value="view"
                            id="<?php echo $row["id"]; ?>" class="btn btn-primary  btn-sm ar_data" />

                           <a href="edit_articles.php?id=<?php echo $row['id'];?>" class="btn btn-info btn-sm">  
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>

                          <a class="btn btn-danger btn-sm" href="view_articles.php?artid=<?php echo $row['id'];?>"  onClick=" return confirm('Do you really want to delete');">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                  </td>
                </tr>
              
                  <?php $cnt = $cnt + 1;}
                ?>
                </tbody>
                <tfoot>
                 <tr>
                                     <th>S/N</th>

                   <th>Featured image</th>
                  <th>Title</th>
                  <th>Article body</th>
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
                                <h4 class="modal-title">Article Details</h4>
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
                                            <dt class="col-sm-4">Title</dt>
                                            <dd class="col-sm-8" id="ar_title"></dd>
                                            <dt class="col-sm-4">Description</dt>
                                            <dd class="col-sm-8" id="ar_desc"></dd>
                                            <dt class="col-sm-4">Featured Image</dt>
                                            <dd class="col-sm-8" id="ar_img"></dd>

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

    $(document).ready(function(){
        $('.ar_data').click(function(){
            var leader_id = $(this).attr("id");
            $.ajax({
                url:"view_articles.php",
                method:"post",
                data:{view_article:leader_id},
                dataType: 'json',
                success:function(res){
                    console.log(res);
                    $('#ar_title').html(res.title);
                    $('#ar_desc').html(res.description);
                    $('#ar_img').html(`<img src=${res.featured_image} alt="img" style="height: 150px; width: 150px">`);
                    $('#dataModal').modal("show");
                }
            });

        });
    });


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
