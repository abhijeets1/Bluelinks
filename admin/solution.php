<?php
    include "header.php";
    include "config.php";
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Solution Posts</h1>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Solution</th>
                          <th>Creation Date/Time</th>
                          <th>Last Updated</th>
                          <th>Link</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                            #-------------Pagination-------------#
                            $limit = 10;
                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = 1;
                            }
                            $offset = ($page - 1) * $limit;
                            #-------------Pagination-------------#
                            $query = "SELECT Sid, Ptitle, Sdescription, Screationdt, Pid, Slastupdated FROM solutionsdata JOIN postsdata ON Spid = Pid WHERE Screator = {$_SESSION["uid"]} ORDER BY Screationdt DESC LIMIT {$offset}, {$limit};";
                            $result = mysqli_query($conn, $query) OR die("Query Failed");
                            if(mysqli_num_rows($result) > 0) {
                              while($row = mysqli_fetch_assoc($result)) {
                                  $serial_no = $offset + 1;
                        ?>
                          <tr>
                              <td class='id'><?php echo $serial_no; ?></td>
                              <td><?php echo $row["Ptitle"]; ?></td>
                              <td><?php echo $row["Sdescription"]; ?></td>
                              <td><?php echo $row["Screationdt"]; ?></td>
                              <td><?php echo $row["Slastupdated"]; ?></td>
                              <td><a href="<?php echo "{$hostname}/single.php?Pid=" . $row["Pid"]; ?>">Link</a></td>
                              <td class='edit'><a href='update-solution.php?Pid=<?php echo $row["Pid"]; ?>&Sid=<?php echo $row["Sid"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-solution.php?Pid=<?php echo $row["Pid"]; ?>&Sid=<?php echo $row["Sid"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                        <?php
                               }
                            }
                        ?>
                      </tbody>
                  </table>
                  <?php
                      #-------------Pagination-------------#
                      $sql_query_pagination= "SELECT Sid FROM solutionsdata WHERE Screator = {$_SESSION['uid']};";
                      $result_pagination = mysqli_query($conn, $sql_query_pagination) or die("Query Failed.");
                      if(mysqli_num_rows($result_pagination) > 0){
                          $total_records = mysqli_num_rows($result_pagination);
                          $total_pages = ceil($total_records / $limit);
                          echo '<ul class="pagination admin-pagination">';
                          if($page > 1){
                              echo '<li><a href="solution.php?page='.($page-1).'">Prev</a></li>';
                          }
                          for($i = 1; $i <= $total_pages; $i++){
                              if($i == $page){
                                  $active = "active";
                              }else{
                                  $active = "";
                              }
                              echo '<li class="'.$active.'"><a href="solution.php?page='.$i.'">'.$i.'</a></li>';
                          }
                          if($total_pages > $page){
                              echo '<li><a href="solution.php?page='.($page + 1).'">Next</a></li>';
                          }
                          echo '</ul>';
                      }
                      #-------------Pagination-------------#
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>