<?php
	include 'header.php';
	include 'config.php';
	if(!isset($_SESSION['verified'])) {
		header("Location: {$hostname}/admin/profile.php");
		die();
	} else {
		unset($_SESSION['verified']);
	}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-10">
        <h1 class="admin-heading">Update Profile</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="save-updated-profile.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php
                $sql_query = "SELECT Uimg, Uname, Udob, Uage, Ugender, Uusername, Uprivate FROM usersdata WHERE Uid = {$_SESSION['uid']}";
                $result = mysqli_query($conn, $sql_query);
                $row = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="id" value="<?php echo $_SESSION["uid"]; ?>">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" id="exampleInputUsername" value="<?php echo $row["Uname"]; ?>">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputUsername" value="<?php echo $row["Uusername"]; ?>" disabled>
            </div>
            <div class="form-group">
                <label>DOB</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $row["Udob"]; ?>">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="text" name="age" class="form-control" value="<?php echo $row["Uage"]; ?>">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control">
                <?php
                	if($row["Ugender"] === "male") {
                		echo "<option selected value='male'>Male</option>";
	                    echo "<option value='female'>Female</option>";
                	} else {
                		echo "<option value='male'>Male</option>";
	                    echo "<option selected value='female'>Female</option>";
                	}
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Account Privacy</label>
                <select name="private" class="form-control">
                <?php
                    if($row["Uprivate"] == 0) {
                        echo "<option selected value='0'>Not Private</option>";
                        echo "<option value='1'>Private</option>";
                    } else {
                        echo "<option value='0'>Not Private</option>";
                        echo "<option selected value='1'>Private</option>";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Update Profile</label>
                <input type="file" name="new_Uimg">
                <img src="upload/<?php echo $row['Uimg']; ?>" height="150px">
                <input type="hidden" name="old_Uimg" value="<?php echo $row['Uimg']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php    
    include "footer.php"; 
?>
