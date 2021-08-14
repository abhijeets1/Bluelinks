<?php
    include "header.php";
    include "config.php";
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
?>
  <div id="main-content">
      <div class="container">
          <div  class="row">
            <div class="col-md-2">
                  <a class="add-new" href="update-profile-verification.php">update profile</a>
              </div>
              <div class="col-md-12">
                  <?php
                      $query = "SELECT Uimg, Uname, Udob, Uage, Uusername, Ucreationdt, Uprivate, Ulastupdated, Ulastlogin, Uemail FROM usersdata
                          WHERE Uid = {$_SESSION['uid']};";
                      $result = mysqli_query($conn, $query) OR die("Query Failed");
                      $row = mysqli_fetch_assoc($result);
                  ?>
                  <div class="post-container">
                        <div class="post-content single-post">
                            <img class="single-feature-profile-image" src="upload/<?php echo $row["Uimg"]; ?>" alt="Image"/>
                            <div class="profile-information">
                                <h4>E-mail : <?php echo $row["Uemail"]; ?></h4>
                                <h4>Name : <?php echo $row["Uname"]; ?></h4>
                                <h4>Username : <?php echo $row["Uusername"]; ?></h4>
                                <h4>DOB : <?php echo $row["Udob"]; ?></h4>
                                <h4>Age : <?php echo $row["Uage"]; ?></h4>
                                <h4>Account created on : <?php echo $row["Ucreationdt"]; ?></h4>
                                <h4>Account last updated on : <?php echo $row["Ulastupdated"]; ?></h4>
                                <h4>Account last logged in : <?php echo $row["Ulastlogin"]; ?></h4>
                                <?php
                                    if($row['Uprivate'] == 0)
                                        echo "<h4>Account Privacy : Not Private.</h4>";
                                    else
                                        echo "<h4>Account Privacy : Private.</h4>";
                                ?>
                            </div>
                        </div>
                    </div>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
