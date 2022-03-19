<!DOCTYPE html>

<?php
	include 'menhely.php';
	$link = getDb(); 

	$create = false;
	if (isset($_POST['create'])) {
		$allatid = mysqli_real_escape_string($link, $_POST['allatid']);
		$gazdiid = mysqli_real_escape_string($link, $_POST['gazdiid']);
		$query = sprintf("INSERT INTO befogad (allatid, gazdiid, datum, statusz) VALUES (%s, %s, curdate(), 0)", $allatid, $gazdiid);
		mysqli_query($link, $query) or die(mysqli_error($link));
		$create = true;
	}
?>

<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Új befogadás</title>
</head>
<body>
	<?php include 'menu.html'; ?>
	<div class="container main-content">
	
	<form method="post">
    <div class="card">
        <div class="card-header">
            Új befogadás
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for='gazdiid'>Leendő gazdi</label>
                <select class="form-control" name='gazdiid' id='gazdiid'>
                <?php
                    $queryGazdi = 'SELECT id, nev FROM gazdi';
                    $resultQueryGazdi = mysqli_query($link, $queryGazdi) or die(mysqli_error($link));
                    while ($rowGazdi = mysqli_fetch_array($resultQueryGazdi)):
                ?>
                    <option value="<?=$rowGazdi['id']?>"><?=$rowGazdi['nev']?></option>
                <?php endwhile; ?>
                </select>
            </div>

                <div class="form-group">
                <label for='allatid'>Befogadott állat</label>
                <select class="form-control" name='allatid' id='allatid'>
                <?php
                    $queryAllat = 'SELECT id, nev FROM allat WHERE id NOT IN (SELECT allatid FROM befogad WHERE vissza IS NULL)';
                    $resultQueryAllat = mysqli_query($link, $queryAllat) or die(mysqli_error($link));
                    while ($rowAllat = mysqli_fetch_array($resultQueryAllat)):
                ?>
                    <option value="<?=$rowAllat['id']?>"><?=$rowAllat['nev']?></option>
                <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="card-footer">
            <input class="btn btn-primary" name="create" type="submit" value="Befogadás" style="background-color:green" />
        </div>
    </div>  
	</form>
	</div>
</body>
</html>