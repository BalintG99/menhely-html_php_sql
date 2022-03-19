<!DOCTYPE html>

<?php 
include 'menhely.php';
$link = getDb(); 

$regextel = '/\+[0-9]{2}-[0-9]{2}-[0-9]{7}/';
if (isset($_POST['update2'])) {
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $telefon = mysqli_real_escape_string($link, $_POST['telefon']);
    $cim = mysqli_real_escape_string($link, $_POST['cim']);
	
	if(preg_match($regextel, $telefon)){
	$query = sprintf("UPDATE gazdi SET nev='%s', telefon='%s', cim='%s' WHERE id=%s",
              $nev, $telefon, $cim, $id);
    mysqli_query($link, $query) or die(mysqli_error($link));
	header("Location: gazdik.php");

    }
	
	else { ?>
		<div class="alert alert-danger" role="alert">
			Hibás formátumban adta meg a telefonszámot. Kérjük próbálja újra!
		</div>
	<?php 
		}
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
    <?php include 'menu.html';
    if (!isset($_GET['id'])) {
       header("Location: gazdik.php");
       return;
    } 
    $id = $_GET['id'];
    $query = sprintf("SELECT id, nev, telefon, cim FROM gazdi where id = %s", 
        mysqli_real_escape_string($link, $id)) or die(mysqli_error($link));
    $eredmeny = mysqli_query($link, $query);
    $row = mysqli_fetch_array($eredmeny);
    if (!$row) {
        header("Location: gazdik.php");
        return;
    }
    ?>
				
    <div class="container main-content">
	
	<div class="card">
		<div class="card-header">
			Gazdi módosítása
		</div>
        <div class="card-body">
	<form method="post" action="">
	<input type="hidden" name="id" id="id" value="<?=$id?>" />

		<div class="form-row">
		<div class="col">
                <label for="nev">Név</label>
                <input required class="form-control" name="nev" id="nev" type="text" />
		</div>
		<div class="col">
            <label for="telefon">Telefonszám</label>
            <input required class="form-control" name="telefon" id="telefon" type="text"  />
			<small id="passwordHelpBlock" class="form-text text-muted">
				( kötelező formátum: +xx-xx-xxxxxxx )
			</small>
        </div>
		</div>
        <div class="form-group">
            <label for="cim">Lakhely</label>
            <input required class="form-control" name="cim" id="cim" type="text" />
			<small id="passwordHelpBlock" class="form-text text-muted">
				( kötelező formátum: [irányítószám] [település], [utca] [házszám] )
			</small>
        </div>
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" name="update2" type="submit" value="Mentés" style="background-color:green" />
        </div>
	</form>
    </div>
	</div>
	
	<?php
       closeDb($link);
    ?>
</body>
</html>