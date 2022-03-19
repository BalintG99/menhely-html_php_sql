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
    <title>Örökbefogadások</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
        <h1>Eddigi örökbefogadások</h1>
		
		<?php
            $querySelect = "SELECT allat.nev as allatnev, gazdi.nev as gazdinev, befogad.id as id, befogad.datum as datum, befogad.vissza as vissza, befogad.statusz as statusz FROM befogad
				inner join gazdi gazdi on gazdi.id = befogad.gazdiid inner join allat allat on allat.id = befogad.allatid;";

            $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
        ?>
		<table class="table table-striped table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Állat neve</th>
                        <th>Befogadó</th>      
                        <th>Befogadva</th>      
                        <th>Visszahozva</th>
                        <th>Státusz</th>
						<th>Szerkesztés</th>
						<th>Visszahozás</th>
						<th>Törlés</th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): 
					if ($row['statusz'] == 1)
						$statusz = "sikeres";
					elseif ($row['statusz'] == 0 and is_null($row['vissza']))
						$statusz = "próbaidő";
					elseif ($row['statusz'] == 0 and !is_null($row['vissza']))
						$statusz = "sikertelen";
				?>				
                    <tr>
                        <td><?=$row['allatnev']?></td>
                        <td><?=$row['gazdinev']?></td>
                        <td><?=$row['datum']?></td>
                        <td><?=$row['vissza']?></td>
                        <td><?=$statusz?> 						
						<a  <?php if ($statusz == "sikertelen") : ?> style='display: none' <?php endif;?> href="changeStat.php?id=<?=$row['id']?>&change"> ↔️ </a>
						</td>
						<td align="center">
							<a class="btn btn-outline-dark btn-sm" href="edit_fogadas.php?id=<?=$row['id']?>">
								szerkesztés
							</a>
						</td>
						<td align="center"><a <a class="btn btn-outline-dark btn-sm" href="edit_fogadas.php?id=<?=$row['id']?>$return"> ↩️</a></td>						
						<td align="center"><a class="btn btn-danger btn-sm" href="edit_fogadas.php?id=<?=$row['id']?>&delete">❌</a></td>
                    </tr>
                <?php endwhile; ?> 
                </tbody>
         </table>
		          <?php
                closeDb($link);
         ?>
		<div class="card" style="width: 18rem;">
		<img src="befogad.jpg" class="card-img-top" alt="örökbefogadás">
		<div class="card-body">
			<h5 class="card-title">Új örökbefogadás</h5>
			<p class="card-text">Ha megtalálta álmai kiskedvencét, és szívesen hazavinné, kattintson ide:</p>
			<a href="add_fogadas.php" class="btn btn-primary" style="background-color:green">Örökbefogadás</a>
		</div>
		</div>
	</div>
</body>
</html>