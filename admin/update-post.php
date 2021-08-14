<?php
    include "header.php";
    include "config.php";
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
    $Pid = $_GET["Pid"];
    #-------------Security-------------#
    $username = $_SESSION["username"];
    $sql_query = "SELECT Pid FROM postsdata WHERE Pcreator = {$_SESSION['uid']}";
    $result = mysqli_query($conn, $sql_query);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        if($Pid == $row["Pid"]) {
            $i++;
        }
    }
    if($i == 0) {
        header("Location: {$hostname}/admin/post.php");
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
        <form action="save-updated-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php
                $sql_query_2 = "SELECT * FROM postsdata WHERE Pid = {$Pid}";
                $result_2 = mysqli_query($conn, $sql_query_2);
                $row_2 = mysqli_fetch_assoc($result_2);
            ?>
            <input type="hidden" name="Pid" value="<?php echo $row_2["Pid"]; ?>">
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="Ptitle"  class="form-control" id="exampleInputUsername" value="<?php echo $row_2["Ptitle"]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputDescription"> Description</label>
                <textarea name="Pdescription" class="form-control"  required rows="5">
                <?php echo $row_2["Pdescription"]; ?>
                </textarea>
            </div>
            <div class="form-group">
                <?php
                    $sql_query_3 = "SELECT * FROM categoriesdata";
                    $result_3 = mysqli_query($conn, $sql_query_3) OR die("Query Failed!");
                ?>
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="Pcategory">
                    <?php 
                        while($row_3 = mysqli_fetch_assoc($result_3)) {
                        if($row_2["Pcategory"] == $row_3["Cid"]) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option {$selected} value='{$row_3['Cid']}' > {$row_3['Cname']} </option>";
                        }
                    ?>
                </select>
            </div>
            <input type="hidden" name="old_category" value="<?php echo $row_2["Pcategory"]; ?>">
            <label for="exampleInputImage">Update Image</label>
            <div class="form-group">
                <input type="file" name="new_Pimg">
                <img src="upload/<?php echo $row_2['Pimg']; ?>" height="150px">
                <input type="hidden" name="old_Pimg" value="<?php echo $row_2['Pimg']; ?>">
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
