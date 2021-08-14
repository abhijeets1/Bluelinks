<?php
    include "config.php";
    session_start();
    if(isset($_SESSION["username"])){
      header("Location: {$hostname}/admin/post.php");
    }
    if(!isset($_SESSION["reset_email"])) {
        header("Location: {$hostname}/admin/reset-password.php");
    }
    $email = $_SESSION['reset_email'];
?>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bluelinks | Reset Password</title>
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
                            Reset Password
                        </h3>
                        <?php
                            $sql_query = "SELECT Uusername FROM usersdata WHERE Uemail = '{$email}';"; 
                            $result = mysqli_query($conn, $sql_query) OR die("Query Failed");
                            $row = mysqli_fetch_assoc($result);
                        ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['email']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="<?php echo $row['Uusername']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="newpassword" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control" required>
                            </div>
                            <input type="submit" name="reset" class="btn btn-primary" value="Reset" />
                        </form>
                        <?php
                            if(isset($_POST["reset"])) {
                                $err = "";
                                if(!empty(trim($_POST["newpassword"])) AND
                                    $_POST["newpassword"] === $_POST["confirmpassword"]) {
                                    if (strlen($_POST["newpassword"]) < '8') {
                                        $err .= "Your Password Must Contain At Least 8 Digits!"."<br>";
                                    }
                                    elseif(!preg_match("#[0-9]+#",$_POST["newpassword"])) {
                                        $err .= "Your Password Must Contain At Least 1 Number!"."<br>";
                                    }
                                    elseif(!preg_match("#[A-Z]+#",$_POST["newpassword"])) {
                                        $err .= "Your Password Must Contain At Least 1 Capital Letter!"."<br>";
                                    }
                                    elseif(!preg_match("#[a-z]+#",$_POST["newpassword"])) {
                                        $err .= "Your Password Must Contain At Least 1 Lowercase Letter!"."<br>";
                                    }
                                    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["newpassword"])) {
                                        $err .= "Your Password Must Contain At Least 1 Special Character!"."<br>";
                                    }
                                } else {
                                    $err .= 'Password Missmatched!'.'<br>';
                                }
                                if(!empty($err)) {
                                    echo '<div class="alert alert-danger">' . $err . '</div>';
                                    die();
                                } else {
                                    $newpassword = sha1($_POST["newpassword"]);
                                    $sql_query = "UPDATE usersdata SET Upassword = '{$newpassword}' WHERE Uemail = '{$email}';"; 
                                    mysqli_query($conn, $sql_query) OR die("Query Failed");
                                    unset($_SESSION['reset_email']);
                                    header("Location: {$hostname}/admin/");
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>