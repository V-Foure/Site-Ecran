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
<div>
    <?php include("../../session.php");
        if (isset($_SESSION['Connexion'])) {
            if ($TheUser->isAdmin()) {
                if (isset($_POST["createEcran"])) {
                    $newecran = new Ecran(null, $_POST["nom"], $_POST["description"], $_POST["lienImage"], $_POST["etoile"]);
                    $newecran->saveInBdd();
                }
    ?>
    
    <form action="" method="Post" class="stars5">
        nom : <input type="text" name="titre" maxlength="100">
        description :<input type="text" name="description">
        lienImage : <input type="text" name="lienImage">

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
        <input type="submit" name="createEcran">
    </form>

    <?php
    } else {
        echo "vous etes un simple visiteur vous n'avez pas acces au crud";
    }
        }

        $Ecran = new Ecran(null, null, null, null, 0);
        $tabEcrans = $Ecran->getAllEcran();
    ?>
    
    <div class="contener">
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach ($tabEcran as $ecran) {
                        $ecran->renderHTML();
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>