<?php 

require_once(MODELS.DS.'Model.php');

/**
 * Class representing the home page model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeModel extends Model {
    /**
     * Public method searching the unprocessed application in the database
     *
     * @return void
     */
    public function getNonTraiteeCandidatures(): ?Array {
        // On initialise la requête
        $request = "SELECT 
        c.Id AS Cle,
        j.Titled AS Poste, 
        c.Name AS Nom, 
        c.Firstname AS Prénom, 
        c.Email AS Email, 
        c.Phone AS Téléphone, 
        s.Titled AS Source

        FROM applications as app
        INNER JOIN Candidates as c on app.Key_Candidates = c.Id
        INNER JOin jobs as j on app.Key_Jobs = j.Id
        INNER JOIN sources as s on app.Key_Sources = s.Id
        WHERE app.Status = 'Non-traitée'
        
        ORDER BY app.Id DESC";
    
        // On lance la requête
        return $this->get_request($request);
    }
    /**
     * Public method searching the contract proposals in the database
     *
     * @return void
     */
    public function getReductProposition(): ?Array {
        // On initialise la requête
        $request = "SELECT 
        j.Titled AS Poste,
        can.Name AS Nom, 
        can.Firstname AS Prenom

        FROM Contracts AS con
        INNER JOIN Candidates AS can ON con.Key_Candidates = can.Id
        INNER JOIN Jobs AS j ON con.Key_Jobs = j.Id
        WHERE con.SignatureDate = NULL
        
        ORDER BY con.Id DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /**
     * Public method searching the metting list
     *
     * @return void
     */
    public function getReductRendezVous(): ?Array {
        // On initialise la requête
        $request = "SELECT 
        c.Name AS Nom, 
        c.Firstname AS Prenom,
        m.Date as Moment
        
        FROM Have_a_meet_with AS meet
        INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id
        INNER JOIN Moments AS m ON meet.Key_Moments = m.Id
        
        WHERE meet.Key_Users = :cle";
        $params = ['cle' => $_SESSION['user_key']];

        // On lance la requête
        $arr = $this->get_request($request, $params);

        if(!empty($arr))
            foreach ($arr as &$row) {
                $row["Jour"] = date('d/m/Y', strtotime($row["Moment"]));
                $row["Heure"] = date('H:i', strtotime($row["Moment"]));
                unset($row["Moment"]);
        }
        return $arr;
    }
}