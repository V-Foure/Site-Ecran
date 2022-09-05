<?php
class Ecran
{
    //Propriété private
    private $id_ = null;
    private $nom_;
    private $description_;
    private $lienImage_;
    private $MoyenneNote_;

    //Methode public
    public function __construct($id, $nom, $description, $lienImage, $note)
    {
        $this->id_ = $id;
        $this->nom_ = $nom;
        $this->description_ = $description;
        $this->lienImage_ = $lienImage;
        $this->MoyenneNote_ = $note;
    }

    public function saveInBdd()
    {
        $nom = addslashes($this->nom_);
        $description = addslashes($this->description_);
        $lienImage = addslashes($this->lienImage_);

        if (is_null($this->id_)) {
            $requetSQL = "INSERT INTO `Ecran`
            ( `nom`, `description`, `lienImage`) 
            VALUES 
            ('" . $nom . "','" . $description . "','" . $lienImage . "')";
            $resultat = $GLOBALS["pdo"]->query($requetSQL);
            $this->id_ = $GLOBALS["pdo"]->lastInsertId();

            $requetSQL = "INSERT INTO `Note` ( `idUser`, `idEcran`, `note`) 
            VALUES ( '".$_SESSION['id']."', '".$this->id_."', '".$this->MoyenneNote_."');";
            $GLOBALS["pdo"]->query($requetSQL);
        } else {
            echo "tu va updater ecran id N°" . $this->id_;

            $requetSQL = "UPDATE `Ecran` SET 
            `nom`='" . $nom . "',
            `description`='" . $description . "',
            `lienImage`='" . $lienImage . "' 
            WHERE `id` = '" . $this->id_ . "'";

            $resultat = $GLOBALS["pdo"]->query($requetSQL);
        }
    }

    public function deleteInBdd()
    {
        if (!is_null($this->id_)) {
            $requetSQL = "DELETE FROM `Ecran`WHERE
            id = '" . $this->id_ . "'";
            $GLOBALS["pdo"]->query($requetSQL);
            echo "Ecran " . $this->titre_ . " a été supprimé";
        }
    }

    public function setEcranById($id)
    {
        $RequetSql = "Select Ecran.id,Ecran.titre,Ecran.resume,Ecran.lienImage, AVG(Note.note) as 'note'
         FROM Ecran,Note,User
        WHERE
        Ecran.id = Note.idEcran
        AND
        Note.idUser = User.id
        AND
        Ecran.id = '" . $id . "'  
        Group By Ecran.id;";

        $resultat = $GLOBALS["pdo"]->query($RequetSql);
        if ($resultat->rowCount() > 0) {
            $tab = $resultat->fetch();
            $this->id_ = $tab['id'];
            $this->nom_ = $tab['nom'];
            $this->description_ = $tab['description'];
            $this->lienImage_ = $tab['lienImage'];
            $this->MoyenneNote_ = $tab['note'];
        }
    }

    public function getAllEcran()
    {
        $ListEcrans = array();
    
        $RequetSql = "Select Ecran.id,Ecran.titre,Ecran.resume,Ecran.lienImage, AVG(Note.note) as 'note'
        FROM Ecran,Note,User
        WHERE
        Ecran.id = Note.idEcran
        AND
        Note.idUser = User.id
        Group By Ecran.id;";

        $resultat = $GLOBALS["pdo"]->query($RequetSql);
        while ($tab = $resultat->fetch()) {
            $lecran = new Ecran($tab['id'], $tab['nom'], $tab['description'], $tab['lienImage'], $tab['note']);
            array_push($ListEcrans, $lecran);
        }

        return $ListEcrans;
    }

    public function getNom()
    {
        return $this->nom_;
    }
    public function getId()
    {
        return $this->id_;
    }
    public function getDescription()
    {
        return $this->description_;
    }

    public function renderHTML()
    {
    ?>

    <div class="col mb-5">
        <div class="card h-100 white">
            <div class="badge bg-yellow text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Vote</div>
                <img class="card-img-top" src="<?= $this->getLienImage(); ?>" alt="..." />
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder"><?= $this->titre_;?></h5>
                                <div class="d-flex justify-content-center small text-warning mb-2">
                            
                                <?php
                                    for ($i=0; $i < round($this->MoyenneNote_); $i++) { 
                                    echo'<div class="bi-star-fill"></div>';
                                    }
                                    for ($i=$i; $i < 5; $i++) { 
                                        echo'<div class="bi-star"></div>';
                                    }
                                ?>

                                <?= round($this->MoyenneNote_)."/5" ?>

                                </div>

                            <span class="text-muted"><?= $this->resume_;?></span>
                        </div>
                    </div>
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn login_btn mt-auto" href="CRUDFilm.php">Infos +</a></div>
            </div>
        </div>
    </div>
    <?php
    }

    public function getImage()
    {
        $imageHTML = '<img src="' . $this->lienImage_ . '"alt="' . $this->nom_ . '"/>';
        return $imageHTML;
    }

    public function getLienImage()
    {
        return $this->lienImage_;
    }

    public function setNom($nom)
    {
        $this->nom_ = $nom;
    }
    public function setDescription($description)
    {
        $this->description_ = $description;
    }
    public function setLienImage($lienImage)
    {
        $this->lienImage_ = $lienImage;
    }
}
?>