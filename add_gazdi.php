<!DOCTYPE html>

<?php
	include 'menhely.php';
	$link = getDb(); 

	$regextel = '/\+[0-9]{2}-[0-9]{2}-[0-9]{7}/';
	if (isset($_POST['create'])) {
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $telefon = mysqli_real_escape_string($link, $_POST['telefon']);
    $cim = mysqli_real_escape_string($link, $_POST['cim']);
	
	if(preg_match($regextel, $telefon)){
		$createQuery = sprintf("INSERT INTO gazdi (nev, telefon, cim) VALUES ('%s', '%s', '%s')",
		$nev, $telefon, $cim );
		mysqli_query($link, $createQuery) or die(mysqli_error($link));
		header("Location: gazdik.php");
	}
	
	else  { ?>
		<div class="alert alert-danger" role="alert">
			Hibás formátumban adta meg a telefonszámot. Kérjük próbálja újra!
		</div>
	<?php
		}
		mysqli_close ($link);
	}
	?>


<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Új örökbefogadó</title>
</head>
<body>
	<?php include 'menu.html'; ?>
	<div class="container main-content">
	<form method="post" action="">
    <div class="card">
        <div class="card-header">
            Új örökbefogadó hozzáadása
        </div>
        <div class="card-body">
		<div class="form-row">
		<div class="coll col-md-6">
                <label for="nev">Név</label>
                <input required class="form-control" name="nev" id="nev" type="text" />
			</div>
		    <div class="coll col-md-6">
                <label for="faj">Telefonszám</label>
                <input required class="form-control" name="telefon" id="telefon" type="text"  />
				<small id="passwordHelpBlock" class="form-text text-muted">
					( kötelező formátum: +xx-xx-xxxxxxx )
				</small>
            </div>
			
			</div>
            <div class="form-group">
                <label for="fajta">Lakhely</label>
                <input required class="form-control" name="cim" id="cim" type="text" />
				<small id="passwordHelpBlock" class="form-text text-muted">
					( kötelező formátum: [irányítószám] [település], [utca] [házszám] )
				</small>
            </div>
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" name="create" type="submit" value="Felvétel" style="background-color:green" />
        </div>
    </div>
	</div>
    </form>

</body>	
	