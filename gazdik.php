<!DOCTYPE html>

<?php
include 'menhely.php';
$link = getDb(); 
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Örökbefogadók</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
		<h1> Örökbefogadók </h1>
		
	<?php
        $search = null;
		$radioval = null;
		$filter = false;
		
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        }
		if (isset($_POST['radios'])) {
            $radioval = $_POST['radios'];
		}
		if (isset($_POST['checkbox'])) {
            $filter = $_POST['checkbox'];
        }
    ?>
		<div class="card">
		<div class="card-body">
		
		<h4 class="card-title">Keresés: </h4>
		
		<form class="form" method="post">
		<input style="width:600px;margin-left:1em;" class="form-control" type="search" name="search" value="<?=$search?>">						
				
		<div class="form-check">
			<input class="form-check-input" type="radio" name="radios" id="button1" value="gazdi" checked>
			<label class="form-check-label" for="button1">
				keresés név alapján
			</label>
		</div>
		
		<div class="form-check">
			<input class="form-check-input" type="radio" name="radios" id="button2" value="allat">
			<label class="form-check-label" for="button2">
				keresés befogadott állat neve alapján
			</label>
		</div>
		
		<div class="form-check">
			<input class="form-check-input" type="checkbox" name="checkbox" value="filter" id="defaultCheck1">
			<label class="form-check-label" for="defaultCheck1">
				Csak tiltott örökbefogadók listázása
			</label>
		</div>
		
		<button class="btn btn-primary" style="margin-left:1em; background-color:green";" type="submit" >keres</button>
		</form>
		</div>
		</div>
	
	<?php
        $querySelect = "SELECT DISTINCT gazdi.id, gazdi.nev, gazdi.telefon, gazdi.cim FROM gazdi
			inner join befogad befogad on befogad.gazdiid = gazdi.id inner join allat a on a.id = befogad.allatid ";
		if ($search and $radioval == "gazdi") {
            $querySelect = $querySelect . sprintf(" WHERE LOWER(gazdi.nev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
		}
        $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
		
		if ($search and $radioval == "allat") {
            $querySelect = $querySelect . sprintf(" WHERE LOWER(a.nev) LIKE '%%%s%%'",
				mysqli_real_escape_string($link, strtolower($search)));
		}
        $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
		
		if ($filter) {
			$querySelect = $querySelect . sprintf(" and befogad.statusz is false and befogad.vissza is not null");
		}
		$eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
    ?>
	<table class="table table-striped table-sm table-bordered" >
        <thead class="thead-dark">
            <tr>
                <th>Név</th>
                <th>Telefonszám</th>      
                <th>Lakhely</th>
				<th>Szerkesztés</th>
				<th>Törlés</th>				
            </tr> 
        </thead>
		<tbody>
            <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                <tr>
                    <td><?=$row['nev']?></td>
                    <td><?=$row['telefon']?></td>
                    <td><?=$row['cim']?></td>
					<td align="center">
						<a class="btn btn-outline-dark btn-sm" href="edit_gazdi.php?id=<?=$row['id']?>">
							szerkesztés
						</a>
					</td>
					<td align="center"><a href="delete_gazdi.php?id=<?=$row['id']?>">❌</a></td>
                </tr>
            <?php endwhile; ?> 
        </tbody>
    </table>
	
    <?php
        closeDb($link);
    ?>
	<div class="card" style="width: 18rem;">
		<img src="gazdireg.jpg" class="card-img-top" alt="kutya a gazdájával">
		<div class="card-body">
			<h5 class="card-title">Új gazdi regisztrálása</h5>
			<p class="card-text">Itt regisztrálhat új örökbefogadót</p>
			<a href="add_gazdi.php" class="btn btn-primary" style="background-color:green">Form kitöltése</a>
		</div>
	</div>
	</div>

</body>	 