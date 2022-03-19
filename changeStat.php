
<?php 
include 'menhely.php';
$link = getDb(); 

echo ($_GET['id']);

if (isset($_GET['change'])) {
	$id = $_GET['id'];
    $query = sprintf("UPDATE befogad SET statusz = NOT statusz WHERE id=%s",
        $id);

    mysqli_query($link, $query) or die(mysqli_error($link));
	header("Location: fogadasok.php");
}

/*if ($_GET['return']) {
    $query = sprintf("UPDATE befogad SET vissza = curdate(), statusz = 0 WHERE id=%s",
        $id);

    mysqli_query($link, $query) or die(mysqli_error($link));
	header("Location: fogadasok.php");
}*/
?> 