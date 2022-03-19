<!DOCTYPE html>

<?php
	include 'menhely.php';
	$link = getDb(); 

	if (isset($_POST['create']) and $_POST['nev'] and $_POST['faj'] and $_POST['fajta'] and $_POST['behozva']) {
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $faj = mysqli_real_escape_string($link, $_POST['faj']);
    $fajta = mysqli_real_escape_string($link, $_POST['fajta']);
    $behozva = $_POST['behozva'];
    $leiras = mysqli_real_escape_string($link, $_POST['leiras']);
    $createQuery = sprintf("INSERT INTO allat(nev, faj, fajta, behozva, leiras) VALUES ('%s', '%s', '%s', '%s', '%s')",
	$nev, $faj, $fajta, $behozva, $leiras);
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
	header("Location: allat.php");
}
?>

<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Új állat</title>
</head>
<body>
	<?php include 'menu.html'; ?>
	<div class="container main-content">
	<form method="post" action="">
    <div class="card">
        <div class="card-header">
            Új állat hozzáadása
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="nev">Név</label>
                <input required class="form-control" name="nev" id="nev" type="text" />
            </div>
			<div class="form-group">
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
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" name="create" type="submit" value="Felvétel" style="background-color:green" />
        </div>
    </div>
	</div>
    </form>
	
	