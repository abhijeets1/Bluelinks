<?php
    include "config.php";
    session_start();
    if(isset($_SESSION["username"])){
      header("Location: {$hostname}/admin/post.php");
    }
    if(!isset($_SESSION["email"])) {
        header("Location: {$hostname}/admin/signup.php");
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
                        <h3 class="heading"> </h3>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fullname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>DOB</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Post Profile Image</label>
                                <input type="file" name="Uimg" required>
                            </div>
                            <input type="submit" name="signup" class="btn btn-primary" value="Signup" />
                        </form>
                        <?php
                            if(isset($_POST["signup"])) {
                                $fullname = trim(mysqli_real_escape_string($conn,$_POST["fullname"]));
                                $username = trim(mysqli_real_escape_string($conn,$_POST["username"]));
                                if(empty($fullname))
                                    echo '<div class="alert alert-danger">Full Name field is empty!</div>';
                                if(empty($username))
                                    echo '<div class="alert alert-danger">Username field is empty!</div>';
                                $sql_query = "SELECT Uid FROM usersdata WHERE Uusername = '{$username}';";
                                $result = mysqli_query($conn, $sql_query) OR die("Query Failed");
                                if(mysqli_num_rows($result) != 0) {
                                    echo '<div class="alert alert-danger">Username Already Exists!</div>';
                                    die();   
                                }
                                $err = "";
                                if(!empty(trim($_POST["password"])) AND
                                    $_POST["password"] === $_POST["confirmpassword"]) {
                                    if (strlen($_POST["password"]) < '8') {
                                        $err .= "Your Password Must Contain At Least 8 Digits!"."<br>";
                                    }
                                    elseif(!preg_match("#[0-9]+#",$_POST["password"])) {
                                        $err .= "Your Password Must Contain At Least 1 Number!"."<br>";
                                    }
                                    elseif(!preg_match("#[A-Z]+#",$_POST["password"])) {
                                        $err .= "Your Password Must Contain At Least 1 Capital Letter!"."<br>";
                                    }
                                    elseif(!preg_match("#[a-z]+#",$_POST["password"])) {
                                        $err .= "Your Password Must Contain At Least 1 Lowercase Letter!"."<br>";
                                    }
                                    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
                                        $err .= "Your Password Must Contain At Least 1 Special Character!"."<br>";
                                    }
                                } else {
                                    $err .= 'Password Missmatched!'.'<br>';
                                }
                                if(!empty($err)) {
                                    echo '<div class="alert alert-danger">' . $err . '</div>';
                                    die();
                                } else {
                                    #-------------Saving_Image-------------#
                                    if($_FILES['Uimg']['error'] == 0) {
                                        $file_name = $_FILES['Uimg']['name'];
                                        $file_tmp = $_FILES['Uimg']['tmp_name'];
                                        $tmp_var = explode('.',$file_name);
                                        $file_ext = end($tmp_var);
                                        $extensions = array("jpeg","jpg","png");
                                        if(in_array($file_ext,$extensions) === false) {
                                            echo "<div class='alert alert-danger'><h3 style='text-align: center;'>Failed To Upload Image.</h3>This extension file not allowed, Please choose a JPG or PNG file.<h3> </h3></div>";
                                            die();
                                        }
                                        $new_img_name = time()."-".basename($file_name);
                                        $target = "upload/".$new_img_name;
                                        move_uploaded_file($file_tmp,$target);
                                    }
                                    else {                                    
                                        echo "<div class='alert alert-danger'><h3 style='text-align: center;'>Failed To Upload Image.</h3>File size must be 2mb or lower.<h3> </h3></div>";
                                        die();
                                    }
                                    $email = $_SESSION['email'];
                                    $gender = mysqli_real_escape_string($conn,$_POST["gender"]);
                                    $dob = mysqli_real_escape_string($conn,$_POST["dob"]);
                                    $tmp_var = explode('-',$dob);
                                    $age = ((date("Y") + 0) - ($tmp_var[0] + 0));
                                    $password = sha1($_POST["password"]);
                                    $creationdt = date("d-m-Y H:i:s");
                                    #-------------Saving_Profile-------------#  
                                    $sql_query = "INSERT INTO usersdata(Uimg, Uname, Udob, Uage, Ugender, Uusername, Ucreationdt, Upassword, Uemail) VALUES ('{$new_img_name}', '{$fullname}', '{$dob}', {$age}, '{$gender}', '{$username}', '{$creationdt}', '{$password}', '{$email}');"; 
                                    mysqli_query($conn, $sql_query) OR die("Query Failed");
                                    unset($_SESSION['email']);
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