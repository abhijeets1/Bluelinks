<?php
    include "config.php";
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
    if(isset($_SESSION["verified"])){
        header("Location: {$hostname}/admin/update-profile.php");
    }
?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bluelinks</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/blblack.png">
                        <h3 style="text-align: center;" class="heading">Verify Account</h3>
                        <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="Verify" />
                        </form>
                        <?php
                            if(isset($_POST["login"])) {
                                $username = mysqli_real_escape_string($conn,$_POST["username"]);
                                $password = sha1($_POST["password"]);
                                $mysql_query = "SELECT Uid FROM usersdata WHERE Uusername = '{$username}' AND Upassword = '{$password}'";
                                $result =  mysqli_query($conn, $mysql_query);
                                if(mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    if($row['Uid'] != $_SESSION['uid']) {
                                        echo '<div class="alert alert-danger">Only Logged in account can be Updated!</div>';
                                        die();
                                    }
                                    $_SESSION["verified"] = 1;
                                    header("Location: {$hostname}/admin/update-profile.php");
                                } else {
                                    echo '<div class="alert alert-danger">Incorrect Username or Password!</div>';
                                }
                            }
                        ?>
                        <!-----------Login----------->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>