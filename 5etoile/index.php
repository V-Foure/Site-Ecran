<?php include("../classes/Note.php");
try {
    $ipserver = "";
    $nomBase = "topecran_bdd";
    $loginPrivilege = "SiteWeb";
    $passPrivilege = "SiteWeb";

    $GLOBALS["pdo"] = new PDO('mysql:host=' . $ipserver . ';dbname=' . $nomBase . '', $loginPrivilege, $passPrivilege);
} catch (Exception  $error) {
    $error->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <form action="" method="post" class="stars5" onclick="this.submit();" >
        <div class="starRating">
            <input id="s5" type="radio" name="etoile" value="5">
            <label for="s5">5</label>
            <input id="s4" type="radio" name="etoile" value="4">
            <label for="s4">4</label>
            <input id="s3" type="radio" name="etoile" value="3">
            <label for="s3">3</label>
            <input id="s2" type="radio" name="etoile" value="2">
            <label for="s2">2</label>
            <input id="s1" type="radio" name="etoile" value="1">
            <label for="s1">1</label>
        </div> 
    </form>
<?php
    if(isset($_POST["etoile"])){
        echo "la note est : ".$_POST["etoile"];
        $Note = new Note(1,1,$_POST["etoile"]);
        $Note->saveInBdd();
    }
?>
</body>
</html>