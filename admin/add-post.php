<?php
    include "header.php";
    include "config.php";
?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="save-post.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="Ptitle" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="Pdescription" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <?php
                              $sql_query = "SELECT * FROM categoriesdata";
                              $result = mysqli_query($conn, $sql_query) OR die("Query Failed!");
                          ?>
                          <label for="exampleInputPassword1">Category</label>
                          <select name="Pcategory" class="form-control">
                            <?php 
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option {$selected} value='{$row['Cid']}' > {$row['Cname']} </option>";
                                }
                            ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="Pimg">
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
