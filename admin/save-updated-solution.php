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
	$Pid = $_POST["Pid"];
    $Sid = $_POST["Sid"];
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
        #-------------Updating_Image-------------#
        if($_FILES["new_Simg"]["name"] === "") {
            $new_img_name = $_POST["old_Simg"];
        } 
        else if($_FILES['new_Simg']['error'] == 0) {
            $file_name = $_FILES['new_Simg']['name'];
            $file_tmp = $_FILES['new_Simg']['tmp_name'];
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
        $Sdescription = trim(addslashes($_POST["Sdescription"]));
        $Simg = $new_img_name;
        $dt = date("d-m-Y H:i:s");
        echo $sql_query = "UPDATE solutionsdata SET Sdescription = '{$Sdescription}', Simg = '{$Simg}', Slastupdated = '{$dt}' WHERE Spid = {$Pid} AND Sid = {$Sid};";
	    mysqli_query($conn, $sql_query) OR die("Query Failed");
	    header("Location: {$hostname}/admin/solution.php");
    }
?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>