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
    #-------------Saving_Image-------------#
    if($_FILES['Pimg']['name'] === "") {
        $new_img_name = "88775.JPG";
    }
    else if($_FILES['Pimg']['error'] == 0) {
        $file_name = $_FILES['Pimg']['name'];
        $file_tmp = $_FILES['Pimg']['tmp_name'];
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
    #-------------Saving_Post-------------#
  	session_start();
  	$Ptitle = addslashes($_POST["Ptitle"]);
  	$Pdescription = addslashes($_POST["Pdescription"]);
  	$Pcreator = $_SESSION["uid"];
  	$Pcategory = $_POST["Pcategory"];
  	$Pcreationdt = date("d-m-Y H:i:s");
  	$Pimg = addslashes($new_img_name);
    echo $sql_query = "INSERT INTO postsdata (Ptitle, Pdescription, Pcreator, Pcategory, Pcreationdt, Pimg) VALUES ('{$Ptitle}', '{$Pdescription}', {$Pcreator}, {$Pcategory}, '{$Pcreationdt}', '{$Pimg}');";
    mysqli_query($conn, $sql_query) OR die("Query Failed1");
    header("Location: {$hostname}/admin/post.php")
?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>