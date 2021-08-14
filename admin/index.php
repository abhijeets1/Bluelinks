<?php
    include "config.php";
    session_start();
    if(isset($_SESSION["username"])){
      header("Location: {$hostname}/admin/post.php");
    }
?>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bluelinks | Login</title>
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
                        <h3 style="text-align: center;" class="heading">
                            <a href="index.php">Login</a>
                            <a href="signup.php">Signup</a>
                        </h3>
                        <!-----------Login----------->
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <h4 style="text-align: center;" class="heading">
                            <a href="reset-password.php">Forgot Password?</a>
                        </h4>
                        <?php
                                if(isset($_POST["login"])) {
                                    $username = mysqli_real_escape_string($conn,$_POST["username"]);
                                    $password = sha1($_POST["password"]);
                                    $mysql_query = "SELECT Uid, Uusername FROM usersdata WHERE Uusername = '{$username}' AND Upassword = '{$password}'";
                                    $result =  mysqli_query($conn, $mysql_query);
                                    if(mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $_SESSION["username"] = $row["Uusername"];
                                        $_SESSION["uid"] = $row["Uid"];
                                        $dt = date("d-m-Y H:i:s");
                                        $mysql_query = "UPDATE usersdata SET Ulastlogin = '{$dt}' WHERE Uid = {$row['Uid']}";
                                        mysqli_query($conn, $mysql_query) OR die("Query Failed");
                                        header("Location: {$hostname}/admin/post.php");
                                    } else {
                                        echo '<div class="alert alert-danger">Incorrect Username or Password</div>';
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