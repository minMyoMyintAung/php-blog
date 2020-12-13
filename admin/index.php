
<?php

  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ){
    header('location: login.php');
  }
 ?>
 <?php include 'header.html'; ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Blog listing</h3>
                </div>
                <!-- /.card-header -->

                <?php

                  if (!empty($_GET['pageno'])) {
                    $pageno=$_GET['pageno'];
                  }else {
                    $pageno=1;
                  }
                  $numOfrecs=2;
                  $offset=($pageno - 1) * $numOfrecs;

                  if (empty($_POST['search'])) {
                    $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                    $stmt->execute();
                    $rawResult=$stmt->fetchAll();
                    $total_page=ceil(count($rawResult)/$numOfrecs);

                    $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
                    $stmt->execute();
                    $result=$stmt->fetchAll();
                  }
                    else {
                      $searchKey = $_POST['search'];
                      $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                      $stmt->execute();
                      $rawResult=$stmt->fetchAll();
                      $total_page=ceil(count($rawResult)/$numOfrecs);

                      $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                      $stmt->execute();
                      $result=$stmt->fetchAll();
                    }
                 ?>

                <div class="card-body">
                  <div>
                    <a href="add.php" class="btn btn-success"> New blog post </a>
                  </div> <br>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th style="width:14%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if ($result) {
                            $i=1;
                          foreach ($result as $value) {
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $value['title']; ?></td>
                              <td><?php echo substr($value['content'],0,100); ?></td>
                              <td>
                                <a href="edit.php?id=<?php echo $value['id'];  ?>" class="btn btn-warning"> Edit</a>
                                <a href="delete.php?id=<?php echo $value['id']; ?>" class="btn btn-danger"> Delete</a>
                              </td>
                            </tr>

                        <?php
                        $i++;
                          }
                        }
                       ?>

                    </tbody>
                  </table> <br>
                  <nav aria-label="Page navigation example" style="float:right">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                      <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>" >
                        <a class="page-link" href="<?php if($pageno<=1){echo '#';}else {echo "?pageno=".($pageno-1); }?>">Previous</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                      <li class="page-item <?php if($pageno>=$total_page){echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($pageno>=$total_page){echo '#';}else {echo "?pageno=".($pageno+1);} ?>">Next</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_page; ?>">Last</a></li>
                    </ul>
                  </nav>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
    <?php include 'footer.html'; ?>
