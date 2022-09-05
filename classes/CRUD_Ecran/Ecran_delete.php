
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="../../css/styles.css" rel="stylesheet" />
   
</head>
<body>
    <?php include("../../session.php");
        $Ecran = new Ecran(null,null,null,null,0);
        if(isset($_POST["DeleteEcran"])){
            $Ecran->setEcranById($_POST["id"]);
            $Ecran->deleteInBdd();
        }

        $tabEcrans = $Ecran->getAllEcran();

        if(isset($_SESSION['Connexion'])){
    ?>
        h1> Index </h2>
        <div> Bienvenu <?php echo $TheUser->getLogin()?></div>

        <?php
            if($TheUser->isAdmin()){
                echo "vous etes admin"; 
                
            if(isset($_POST["idEcran"])){
                $Ecran->setEcranById($_POST["idEcran"]);
                $Ecran->renderHTML(); 
        ?>
        
        <form action="" method="Post" >
            <input type="Hidden" name="id"  value="<?= $Ecran->getID()?>">
            <input type="submit" name="DeleteEcran" value="Supprimer Ecran <?= $Ecran->getNom() ?>" >
        </form>
        
        <?php
        }   
        ?>
    
        <form action="" method="Post" onchange="this.submit()">
            <select id="idEcran" name="idEcran">
                <option value="null" >Choisi un écran</option>
                    <?php
                        foreach ($tabEcrans as  $TheEcran) {

                        if($Ecran->getId() == $TheEcran->getId()){
                            $selected = "selected";
                        }else{$selected = "";}

                        echo '<option '.$selected.' value="'.$TheEcran->getId().'">'.$TheEcran->getNom().'</option>';
                    }
                    ?>
            </select>
        </form>
            
        <?php
        }else{
            echo "vous etes un simple visiteur vous n'avez pas acces au crud";
        }
        ?>

        <?php
        }
        ?>
</body>
</html>