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
        Id_Candidates AS Cle,
        Titled_Jobs AS Poste, 
        Name_Candidates AS Nom, 
        Firstname_Candidates AS Prénom, 
        Email_Candidates AS Email, 
        Phone_Candidates AS Téléphone, 
        Titled_sources AS Source

        FROM applications as app
        INNER JOIN Candidates as i on app.Key_Candidates = i.Id_Candidates
        INNER JOin jobs as p on app.Key_Jobs = p.Id_Jobs
        INNER JOIN sources as s on app.Key_Sources = s.Id_Sources
        WHERE app.Status_applications = 'Non-traitée'
        
        ORDER BY app.Id_Applications DESC";
    
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
        Titled_Jobs AS Poste,
        Name_Candidates AS Nom, 
        Firstname_Candidates AS Prenom

        FROM Contracts AS con
        INNER JOIN Candidates AS can ON con.Key_Candidates = can.Id_Candidates
        INNER JOIN Jobs AS p ON con.Key_Jobs = p.Id_Jobs
        WHERE con.SignatureDate_Contracts = NULL
        
        ORDER BY con.Id_Contracts DESC";

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
        Name_Candidates AS Nom, 
        Firstname_Candidates AS Prenom,
        Date_Moments as Moment
        
        FROM Have_a_meet_with AS meet
        INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id_Candidates
        INNER JOIN Moments AS i ON meet.Key_Moments = i.Id_Moments
        
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