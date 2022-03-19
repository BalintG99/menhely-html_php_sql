<?php
include 'menhely.php';
if(isset($_GET['id'])){
	$link=getDb();
	$id = $_GET['id'];
	$query = "DELETE FROM gazdi WHERE id=" . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query);
	
	mysqli_close($link);
}
header ("Location: gazdik.php");
?>