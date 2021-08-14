<?php
    include "config.php";
    session_start();
    if(!isset($_SESSION["username"])){
        header("Localhost: {$hostname}/admin");    
    }
    $page = basename($_SERVER['PHP_SELF']);
    switch($page) {
        case "post.php":
            $page_title = 'All Posts';
            break;
        case "solution.php":
            $page_title = 'All solution Posts';
            break;
        case "user.php":
            $page_title = "News By " . $row_title['Uname'];
            break;
        case "profile.php":
            $page_title = "Profile";
            break;
        default:
            $page_title = '';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bluelinks | <?php echo $_SESSION["username"] . " | " . $page_title; ?></title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <!-- HEADER -->
        <div id="header-admin">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-2">
                        <a href="<?php echo $hostname . "/index.php"; ?>"><img class="logo" src="images/bltransparent.png"></a>
                    </div>
                    <!-- /LOGO -->
                      <!-- LOGO-Out -->
                    <div class="col-md-offset-6  col-md-4">
                        <a href="logout.php" class="admin-logout">Hello <?php echo $_SESSION["username"]; ?>, logout</a>
                    </div>
                    <!-- /LOGO-Out -->
                </div>
            </div>
        </div>
        <!-- /HEADER -->
        <!-- Menu Bar -->
    <?php
        if(!isset($_SESSION['verified'])) {
    ?>
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a href="../">Home</a>
                            </li>
                            <li>
                                <a href='post.php'>Posts</a>
                            </li>
                            <li>
                                <a href="solution.php">Solutions</a>
                            </li>
                            <li>
                                <a href="profile.php">Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        } 
    ?>
        <!-- /Menu Bar -->
