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
    <title>Vendégeink</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
        <h1>Menhelyünk cicái és kutyái</h1>
	
		<?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>
	
		 <form class="form-inline" method="post">
			<div class="card">
			<div class="card-body">
				<h4 class="card-title">Keresés: </h5>
				
				<input style="width:600px;margin-left:1em;" class="form-control" type="search" name="search" value="<?=$search?>">
            <button class="btn btn-primary" style="margin-left:1em; background-color:green";" type="submit" >keres</button>
			</div>
			</div>
		</form>
		
		<?php
            $querySelect = "SELECT id, nev, faj, fajta, behozva, leiras FROM allat";
			if ($search) {
                $querySelect = $querySelect . sprintf(" WHERE LOWER(nev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
			}
            $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
        ?>
		<table class="table table-striped table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Név</th>
                        <th>Faj</th>      
                        <th>Fajta</th>      
                        <th>Behozva</th>
                        <th>Leírás</th>
						<th>Szerkesztés</th>
						<th>Törlés</th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['nev']?></td>
                        <td><?=$row['faj']?></td>
                        <td><?=$row['fajta']?></td>
                        <td><?=$row['behozva']?></td>
                        <td><?=$row['leiras']?></td>
						<td align="center">
							<a class="btn btn-outline-dark btn-sm" href="edit_allat.php?id=<?=$row['id']?>">
								szerkesztés
							</a>
						</td>
						<td align="center"><a href="delete_allat.php?id=<?=$row['id']?>">❌</a></td>
                    </tr>
                <?php endwhile; ?> 
                </tbody>
         </table>

         <?php
                closeDb($link);
         ?>
		 
		<div class="card" style="width: 18rem;">
			<img src="pacsi.jpeg" class="card-img-top" alt="pacsizo kutya">
			<div class="card-body">
				<h5 class="card-title">Új állat hozzáadása</h5>
				<p class="card-text">Az alábbi form kitöltésével új állatot vehet nyilvántartásba</p>
				<a href="add_allat.php" class="btn btn-primary" style="background-color:green">Form kitöltése</a>
			</div>
		</div>
	</div>

</body>