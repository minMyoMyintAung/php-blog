
<?php

  session_start();
  require '../config/config.php';
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ){
    header('location: login.php');
  }

  if ($_POST) {
    $file ='images/'.($_FILES['image']['name']);
    $imgType=pathinfo($file,PATHINFO_EXTENSION);

    if ($imgType!='png' && $imgType!='jpg' && $imgType!='jpeg') {
      echo "<script> alert('image type must be png,jpg,jpeg'); </script>";
    }
    else {
      $title=$_POST['title'];
      $content=$_POST['content'];
      $image=$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);

      $stmt=$pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES(:title,:content,:image,:author_id)");
      $result=$stmt->execute(
        array(
          ':title'=>$title,
          ':content'=>$content,
          ':image'=>$image,
          ':author_id'=>$_SESSION['user_id']
        )
      );
      if ($result) {
        echo "<script> alert('add item successfully'); window.location.href='index.php';  </script>";
      }
        }
  }

 ?>
 <?php include 'header.html'; ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form class="" action="add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="title"> Title </label>
                      <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="content"> Content </label>
                      <textarea name="content" class="form-control" rows="8" cols="80" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="image"> Image </label> <br>
                      <input type="file" name="image" required>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submit" class="btn btn-success" value="SUBMIT">
                      <a href="index.php" class="btn btn-default" type="button"> Back</a>
                    </div>
                  </form>
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
