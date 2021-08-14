<?php
    include "header.php";
    include "config.php";
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
    $Pid = $_GET["Pid"];
    $Sid = $_GET["Sid"];
    #-------------Security-------------#
    $sql_query = "SELECT Sid FROM solutionsdata WHERE Screator = {$_SESSION['uid']} AND Spid = {$Pid}";
    $result = mysqli_query($conn, $sql_query);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        if($Sid == $row["Sid"]) {
            $i++;
        }
    }
    if($i == 0) {
        header("Location: {$hostname}/admin/solution.php");
        die();
    }
    #-------------Security-------------#
    else {
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="save-updated-solution.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php
                $sql_query_2 = "SELECT * FROM solutionsdata WHERE Sid = {$Sid}";
                $result_2 = mysqli_query($conn, $sql_query_2);
                $row_2 = mysqli_fetch_assoc($result_2);
            ?>
            <div>
                <input type="hidden" name="Sid" class="form-control" value="<?php echo $row_2["Sid"]; ?>">
                <input type="hidden" name="Pid" class="form-control" value="<?php echo $Pid; ?>">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="Sdescription" class="form-control"  required rows="5">
                <?php echo $row_2["Sdescription"]; ?>
                </textarea>
            </div>            
            <div class="form-group">
                <label>Post image</label>
                <input type="file" name="new_Simg">
                <img src="upload/<?php echo $row_2['Simg']; ?>" height="150px">
                <input type="hidden" name="old_Simg" value="<?php echo $row_2['Simg']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php
    } #End of else block
    include "footer.php"; 
?>
