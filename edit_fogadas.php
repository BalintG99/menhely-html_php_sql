<!DOCTYPE html>

<?php 
include 'menhely.php';
$link = getDb(); 

$successful_update = false;
if (isset($_GET['return'])) {
    $id = mysqli_real_escape_string($link, $_GET['id']);
    $query = sprintf("UPDATE befogad SET vissza=curdate(), statusz = 0 WHERE id=%s",
            $id);
    mysqli_query($link, $query) or die(mysqli_error($link));
    header("Location: fogadasok.php");
    return;

} else if (isset($_GET['change'])) {
    $query1 = sprintf('UPDATE befogad SET statusz = NOT statusz WHERE id = %s', 
        mysqli_real_escape_string($link, $_GET['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    header("Location: fogadasok.php");
    return;
} else if (isset($_GET['delete'])) {
    $query1 = sprintf('DELETE FROM befogad WHERE id = %s', 
        mysqli_real_escape_string($link, $_GET['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    header("Location: fogadasok.php");
    return;
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="menhely.css">
    <title>Fogadás módosítása</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
        <?php
            if (!isset($_GET['id'])) {
                die('Nincs megadva azonosító');
                return;
            } 
            $id = $_GET['id'];
            $query = sprintf("SELECT allat.nev as allatnev, gazdi.nev as gazdinev, befogad.datum as datum, befogad.vissza as vissza, befogad.statusz as statusz FROM befogad
				inner join gazdi gazdi on gazdi.id = befogad.gazdiid inner join allat allat on allat.id = befogad.allatid;" 
                mysqli_real_escape_string($link, $lendingid));
            $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                die('Nincs ilyen azonosítójú befogadás');
                return;
            }
        ?>
        <h1>Kölcsönzés adatai</h1>
        <?php if ($successful_update): ?>
        <p>
            <span class="badge badge-success">Kölcsönzés módosítva</span>
        </p>
        <?php endif; ?>
        <form method="post" action="edit-lending.php?lendingid=<?=$lendingid?>">
            <input type="hidden" name="id" id="id" value="<?=$lendingid?>" />
            <div class="form-group">
                <label for='tag'>Tag</label>
                <input id="tag" class="form-control" readonly type="text" value="<?=$row['tagnev']?>" />
            </div>

             <div class="form-group">
                <label for='konyv'>Könyv</label>
                <input class="form-control" readonly type="text" id="konyv" value="<?=$row['cim']?>" />
            </div>

             <div class="form-group">
                <label for='kivitel'>Kivitel dátuma</label>
                <input class="form-control" readonly type="date" id="kivitel"value="<?=$row['kivitel']?>" />
            </div>
            <div class="form-group">
                <label for='vissza'>Kivitel dátuma</label>
                <input class="form-control" type="date" id="vissza" name='vissza' value="<?=$row['vissza']?>" />
            </div>
            <input class="btn btn-success" name="return" type="submit" value="Visszahozas" />
            <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
        </form>

        <?php
            closeDb($link);
        ?>
    </div>
</body>
</html