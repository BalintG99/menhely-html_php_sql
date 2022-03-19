<!DOCTYPE html>

<?php 
include 'menhely.php';
$link = getDb(); 

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $faj = mysqli_real_escape_string($link, $_POST['faj']);
    $fajta = mysqli_real_escape_string($link, $_POST['fajta']);
	$behozva = $_POST['behozva'];
    $leiras = mysqli_real_escape_string($link, $_POST['leiras']);
    $query = sprintf("UPDATE allat SET nev='%s', faj='%s', fajta='%s', behozva='%s', leiras='%s' WHERE id=%s",
              $nev, $faj, $fajta, $behozva, $leiras, $id);

    mysqli_query($link, $query) or die(mysqli_error($link));
	header("Location: allat.php");

    }
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Szerkesztés</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
        <?php
            if (!isset($_GET['id'])) {
                header("Location: allat.php");
                return;
            } 
            $id = $_GET['id'];
            $query = sprintf("SELECT id, nev, faj, fajta, behozva, leiras FROM allat where id = %s", 
                mysqli_real_escape_string($link, $id)) or die(mysqli_error($link));
            $eredmeny = mysqli_query($link, $query);
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                header("Location: allat.php");
                return;
            }
        ?>
        <h1>Állat módosítása</h1>
        <form method="post" action="">
            <input type="hidden" name="id" id="id" value="<?=$id?>" />
            <div class="form-group">
				
			<div class="form-group">
                <label for="nev">Név</label>
                <input required class="form-control" name="nev" id="nev" type="text" />
            </div>
			
			
			<div class="form-row">
			
            <div class="col">
                <label for="faj">Faj</label>
                <input required class="form-control" name="faj" id="faj" type="text"  />
            </div>
            <div class="col">
                <label for="fajta">Fajta</label>
                <input required class="form-control" name="fajta" id="fajta" type="text" />
            </div>
			<div class="col">
                <label for="behozva">Behozva</label>
                <input required class="form-control" name="behozva" id="behozva" type="date"  />
            </div>
			</div>
			</div>
			<div class="form-group">
                <label for="leiras">Rövid leírás (opcionális)</label>
                <input class="form-control" name="leiras" id="leiras" type="text" />
            </div>				
            <input class="btn btn-success" name="update" type="submit" value="Mentés" style="background-color:green" />
        </div>
		</form>

        <?php
            closeDb($link);
        ?>
	</div>
</body>
</html>