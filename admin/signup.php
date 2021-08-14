<?php
    include "config.php";
    include "Mailer/mail.php";
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
        <title>Bluelinks | Signup</title>
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
                        <?php if(!isset($_POST['sendotp'])) { ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <input type="submit" name="sendotp" class="btn btn-primary" value="Send OTP" />
                        </form>
                        <?php } ?>
                        <?php
                            if(isset($_POST['sendotp'])) {
                                $email = trim(mysqli_real_escape_string($conn,$_POST["email"]));
                                $mysql_query = "SELECT Uid FROM usersdata WHERE Uemail = '{$email}';";
                                $result =  mysqli_query($conn, $mysql_query);
                                if(mysqli_num_rows($result) > 0) {
                                    echo "<div class='alert alert-danger'>An account on this e-mail adready exists, try login.</div>";
                                    unset($_POST['sendotp']);
                                } else {
                                    $otp = rand(100000,999999);
                                    sendOTP($email, $otp);
                                    $creationdt = date('Y-m-d H:i:s');
                                    $mysql_query = "INSERT INTO otpsdata(Email, OTP, Creationdt) VALUES('{$email}', '{$otp}', '{$creationdt}');";
                                    mysqli_query($conn, $mysql_query);
                                    $mysql_query = "SELECT Id FROM otpsdata WHERE OTP = '{$otp}' AND Creationdt = '{$creationdt}';";
                                    $result = mysqli_query($conn, $mysql_query);
                                    $row = mysqli_fetch_assoc($result);
                                    $id = $row['Id'];
                                }
                            }
                        ?>
                        <?php
                            if(isset($_POST['sendotp'])) {
                        ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <input type="hidden" name="otpid" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label>OTP</label>
                                <input type="text" name="otp" class="form-control" required>
                            </div>
                            <input type="submit" name="verifyotp" class="btn btn-primary" value="Verify OTP" />
                        </form>
                        <?php
                            }
                            if(isset($_POST['verifyotp'])) {
                                $mysql_query = "SELECT OTP, Email FROM otpsdata WHERE Id = {$_POST['otpid']} AND NOW() <= DATE_ADD(Creationdt, INTERVAL 2 MINUTE)";
                                $result = mysqli_query($conn, $mysql_query);
                                if(mysqli_num_rows($result) == 0) {
                                    echo "<div style='text-align: center;' class='alert alert-danger'>OTP Timeout</div>";
                                    $mysql_query = "DELETE FROM otpsdata WHERE Id = {$_POST['otpid']};";
                                    mysqli_query($conn, $mysql_query);
                                    die();
                                } else {
                                    $row = mysqli_fetch_assoc($result);
                                }
                                if($_POST['otp'] == $row['OTP']) {
                                    $_SESSION['email'] = $row['Email'];
                                    $mysql_query = "DELETE FROM otpsdata WHERE Id = {$_POST['otpid']};";
                                    mysqli_query($conn, $mysql_query);
                                    header("Location: {$hostname}/admin/signup2.php");
                                } else {
                                    echo "<div style='text-align: center;' class='alert alert-danger'>Incorrect OTP</div>";
                                    $mysql_query = "DELETE FROM otpsdata WHERE Id = {$_POST['otpid']};";
                                    mysqli_query($conn, $mysql_query);
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>