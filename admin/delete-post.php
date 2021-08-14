<?php
	include "config.php";
	$Pid = $_GET["Pid"];
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
	#-------------Security-------------#
    $username = $_SESSION["username"];
    $sql_query = "SELECT Pid FROM postsdata WHERE Pcreator = {$_SESSION['uid']}";
    $result = mysqli_query($conn, $sql_query);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        if($Pid == $row["Pid"]) {
            $i++;
        }
    }
    if($i == 0) {
        header("Location: {$hostname}/admin/post.php");
        die();
    }
    #-------------Security-------------#
    else {
        #-------------Removing_Image-------------#
        $sql_query = "SELECT Pimg FROM postsdata WHERE Pid = {$Pid};";
        $result = mysqli_query($conn, $sql_query) OR die("Query Failed");
        $row = mysqli_fetch_assoc($result);
        if($row["Pimg"] !== "88775.JPG")
            unlink("upload/".$row['Pimg']);
        #-------------Removing_Solution_Images-------------#
        $sql_query = "SELECT Simg FROM solutionsdata WHERE Spid = {$Pid};";
        $result = mysqli_query($conn, $sql_query) OR die("Query Failed");
        while($row = mysqli_fetch_assoc($result)) {
            if($row["Simg"] !== "88775.JPG")
            unlink("upload/".$row['Simg']);
        }
        #-------------Removing_Solution_Post-------------#
        $sql_query = "DELETE FROM solutionsdata WHERE Spid = {$Pid};";
        mysqli_query($conn, $sql_query) OR die("Query Failed");
        #-------------Removing_Post-------------#
		$sql_query = "DELETE FROM postsdata WHERE Pid = {$Pid};";
		mysqli_query($conn, $sql_query) OR die("Query Failed");
        header("Location: {$hostname}/admin/post.php");
	}
?>