<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bluelinks</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
<?php
    include "config.php";
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
    #-------------Updating_Image-------------#
    if($_FILES['new_Uimg']['name'] === "") {
        $new_img_name = $_POST["old_Uimg"];
    }
    else if($_FILES['new_Uimg']['error'] == 0) {
        $file_name = $_FILES['new_Uimg']['name'];
        $file_tmp = $_FILES['new_Uimg']['tmp_name'];
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
    #-------------Updating_Image-------------#
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $fullname = trim(mysqli_real_escape_string($conn, $_POST["fullname"]));
    $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $private = mysqli_real_escape_string($conn, $_POST["private"]);
    $img = addslashes($new_img_name);
    $dt = date("d-m-Y H:i:s");
    $sql_query = "UPDATE usersdata SET Uname = '{$fullname}', Uage = '{$age}', Udob = '{$dob}', Ugender = '{$gender}', Uimg = '{$img}', Uprivate = {$private}, Ulastupdated = '{$dt}' WHERE Uid = {$id};";
    mysqli_query($conn, $sql_query) OR die("Query Failed");
    header("Location: {$hostname}/admin/profile.php"); 
?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>