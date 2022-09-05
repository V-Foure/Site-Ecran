<?php
class Note{

    //propriété
    private $id_;
    private $idEcran_;
    private $idUser_;
    private $note_;


    //méthode
    public function __construct($newIddUser,$newIdEcran,$NewNote){
        $this->idFilm_ = $newIdEcran;
        $this->idUser_ = $newIddUser;
        $this->note_ = $NewNote;
    }

    public function saveInBdd(){
        if (is_null($this->id_)) {

            $RequetSql = "Select Ecran.id
            FROM Ecran,Note,User
            WHERE
            Ecran.id = Note.idEcran
            AND
            Note.idUser = User.id
            AND
            Ecran.id = '" . $this->idEcran_ . "'  
            AND 
            User.id = '" . $this->idUser_ . "'  
            Group By Ecran.id;";

            $resultat = $GLOBALS["pdo"]->query($RequetSql);
            if ($resultat->rowCount() > 0) {
                $requetSQL = "UPDATE `Note` SET 
                `note`='" . $this->note_ . "'
                WHERE Note.idEcran = '" .$this->idEcran_ . "'
                AND Note.idUser ='" .$this->idUser_ . "'";
                $GLOBALS["pdo"]->query($requetSQL);
            }else{
                $requetSQL = "INSERT INTO `Note` ( `idUser`, `idEcran`, `note`) 
                VALUES ( '".$this->idUser_."', '".$this->idEcran_."', '".$this->note_."');";
                $GLOBALS["pdo"]->query($requetSQL);
                $this->id_ = $GLOBALS["pdo"]->lastInsertId();
            }

        } else {
            $requetSQL = "UPDATE `Note` SET 
            `note`='" . $this->note_ . "',
            WHERE `id` = '" . $this->id_ . "'";
            $GLOBALS["pdo"]->query($requetSQL);
        }
    }

}
?>