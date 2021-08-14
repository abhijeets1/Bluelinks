<?php
	include "config.php";
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: {$hostname}/admin");
        die();
    }
	$Pid = $_GET["Pid"];
    $Sid = $_GET["Sid"];
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
        #-------------Removing_Image-------------#
        echo $sql_query = "SELECT Simg FROM solutionsdata WHERE Sid = {$Sid} AND Spid = {$Pid};";
        $result = mysqli_query($conn, $sql_query) OR die("Query Failed");
        while($row = mysqli_fetch_assoc($result)) {
            if($row["Simg"] !== "88775.JPG")
            unlink("upload/" . $row['Simg']);
        }
        #-------------Removing_Post-------------#
		$sql_query = "DELETE FROM solutionsdata WHERE Sid = {$Sid} AND Spid = {$Pid};";
		mysqli_query($conn, $sql_query) OR die("Query Failed");
        header("Location: {$hostname}/admin/solution.php");
	}
?>