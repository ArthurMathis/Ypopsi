<?php 

/**
 * Abstract class representing a model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
abstract class Model {
    /**
     * Private attribute containing the database connection
     */
    private $connection;

    /**
     * Class' constructor
     */
    public function __construct() {
        $this->makeConnection();
    }

    /**
     * Protected method connecting the application to the database
     */
    protected function makeConnection() {
        try {
            $db_connection  = getenv('DB_CONNEXION');
            $db_host        = getenv('DB_HOST');
            $db_port        = getenv('DB_PORT');
            $db_name        = getenv('DB_NAME');
            $db_user        = getenv('DB_USER');
            $db_password    = getenv('DB_PASS');
    
            // Supprimez le slash dans la valeur de DB_HOST
            $db_host = str_replace('/', '', $db_host);
    
            $db_fetch = "$db_connection:host=$db_host;port=$db_port;dbname=$db_name";

            $this->connection = new PDO($db_fetch, $db_user, $db_password, Array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            die("Connexion à la base de données réchouée. " . $e->getMessage());
        }
        return $this->connection;
    }
    /**
     * Protected method returning the database connection
     */
    protected function getConnection() { return $this->connection; }
    /**
     * Protected method recording application logs
     * 
     * @param Int $user_key The user identification key in the database
     * @param String $action The action title
     * @param String optionnal $description The action description 
     * @return Void
     */
    protected function writeLogs(&$user_key, $action, $description=null) {
        try {
            $this->inscriptActions(
                $user_key, 
                $this->serachType_of_action($action)['Id'], 
                $description
            );

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'enregistrement des logs",
                'msg' => $e
            ]);
        }
    }


    // METHODES DE REQUETES A LA BASE DE DONNEES //
    

    /**
     * Private method checking the request parameters
     * 
     * @param String $request The SQL request
     * @param Array<String> $params The request data Array
     * @return Boolean TRUE if the request executed successfully, FALSE otherwise
     */
    private function test_data_request(&$request, &$params=[]): Bool {
        if(empty($request) || !is_string($request)) 
            throw new Exception("La requête doit être passée en paramètre !");
        elseif(!is_Array($params))
            throw new Exception("Les données de la requête doivent être passsée en paramètre !");
    
        return true;
    }
    /**
     * Private method executing a GET request to the database
     *
     * @param String $request The SQL request
     * @param Array<String> $params The request data parameters
     * @param Boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param Boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return Array|null
     */
    protected function get_request($request, $params = [], $unique=false, $present=false): ?Array {
        if(empty($unique) || !is_bool($unique) || empty($present) || !is_bool($present))  
            $present = false;
    
        if($this->test_data_request($request, $params)) try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);

            if($unique) 
                $result = $query->fetch(PDO::FETCH_ASSOC);
            else 
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result)) {
                if($present) 
                    throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
                
                else 
                    return null;
    
            } else 
                return $result;
    
        } catch(Exception $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 

        return null;
    }
    /**
     * Private method executing a POST request to the database
     *
     * @param String  $request The SQL request
     * @param Array<String>  $params The request data Array
     * @return Boolean
     */
    protected function post_request(&$request, $params): Bool {
        $res = true;
    
        if(!$this->test_data_request($request, $params)) 
            $res = false;
    
        else try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);

        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 
    
        return $res;
    }


    /**
     * Public method returning the users list to autocomplete items
     *
     * @return Void
     */
    public function getAutoCompletUtilisateurs() {
        // On initialise la requête
        $request = "SELECT Identifiant_Utilisateurs FROM Utilisateurs ORDER BY Identifiant_Utilisateurs";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Void
     */
    public function getAutoCompletEtablissements() {
        // On initialise la requête
        $request = "SELECT titled FROM Establishments ORDER BY titled";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the candidate who have a job in the foundation list to autocomplete items
     *
     * @return Void
     */
    public function getEmployee() {
        // On initialise la requête
        $request = "SELECT 
        CONCAT(c.Name, ' ', c.Firstname) AS text

        FROM Candidates AS c
        INNER JOIN Contracts AS con ON c.Id = con.Key_Candidates

        WHERE con.SignatureDate IS NOT NULL
        AND (con.EndDate IS NULL OR con.EndDate > CURDATE())";
    
        // On lance la requête
        return $this->get_request($request, []);
    }
    /**
     * Public method returning the assistants list to autocomplete items
     *
     * @return Void
     */
    public function getHelps() {
        // On inititalise la requête
        $request = "SELECT 
        Id AS id,
        Titled AS text

        FROM Helps";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Void
     */
    public function getQualifications() {
        // On initialise la requête
        $request = "SELECT
        Titled AS text
        
        FROM Qualifications";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the job lost to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompPostes() {
        // On inititalise la requête
        $request = "SELECT Intitule_Postes FROM Postes ORDER BY Intitule_Postes";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the services list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompServices() {
        // On inititalise la requête
        $request = "SELECT Intitule_Services FROM Services ORDER BY Intitule_Services";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the types of contracts list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompTypesContrat() {
        // On initialise la requête
        $request = "SELECT Intitule_Types_de_contrats FROM Types_de_contrats ORDER BY Intitule_Types_de_contrats";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the sources list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompSources() {
        // On initialise la requête
        $request = "SELECT Intitule_Sources FROM Sources ORDER BY Intitule_Sources";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the role liste without the owner
     *
     * @return Void
     */
    public function getAccessibleRoles() {
        // ON initialise la requête
        $request = "SELECT 
        Id_Role AS id,
        Intitule_Role AS text

        FROM Roles";

        // On lance la requête
        return $this->get_request($request);
    }



    // METHODES DE RECHERCHE DANS LA BASE DE DONNEES //

    /**
     * Public method searching one Instant in the database
     *
     * @param Int $cle_instant The Instant's primary key 
     * @return Array
     */
    protected function searchInstant($cle_instant): Array {
        // On initialise la requête
        $request = "SELECT * FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On récupère le résultat
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one establishment 
     *
     * @param Int|String $etablissement The establishment primary key or intitule 
     * @return Array
     */
    protected function searchEtablissement($etablissement): Array {
        if(is_numeric($etablissement)) 
            // On initialise la requête
            $request = "SELECT * FROM Etablissements WHERE Id_Etablissements = :etablissement";
        
        elseif(is_string($etablissement)) 
            // On initialise la requête
            $request = "SELECT * FROM Etablissements WHERE Intitule_Etablissements = :etablissement";

        // On prépare les paramètres de la requête
        $params = [
            'etablissement' => $etablissement
        ];
        
        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one hub in the database
     *
     * @param Int|String $pole The hub primary key or intitule
     * @return Array
     */
    protected function searchPole($pole): Array {
        if(is_numeric($pole)) {
            $request = "SELECT * FROM Poles WHERE Id_Poles = :cle";
            $params = [
                'cle' => $pole
            ];
        
        } elseif(is_string($pole)) {
            $request = "SELECT * FROM Poles WHERE Intitule_Poles = :intitule";
            $params = [
                'intitule' => $pole
            ];
            
        } else 
            throw new Exception("paramètre invalide");

        return $this->get_request($request, $params, true, true);    
    }
    /**
     * Protected method searching one role in the database
     *
     * @param Int|String $role The role primary key or intitule
     * @return Array
     */
    protected function searchRole($role): Array {
        // On initialise la requête
        if(is_numeric($role)) {
            $request = "SELECT * FROM roles WHERE Id_Role = :Id";
            $params = ["Id" => $role];

        } elseif(is_string($role)) {
            $request = "SELECT * FROM roles WHERE Intitule_Role = :Intitule";
            $params = ["Intitule" => $role];

        } else 
            throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    /**
     * Protected method searching one action type in the database
     * @param Int|String $action The type primary key or intitule
     * @return Array
     */
    protected function serachType_of_action($action): Array {
        if($action == null) 
            throw new Exception("Données éronnées. La clé action ou son intitulé sont nécessaires pour rechercher une action !");
        elseif(is_numeric($action)) 
            $request = "SELECT * FROM types_of_actions WHERE Id = :action";
        elseif(is_string($action))
            $request = "SELECT * FROM types_of_actions WHERE Titled = :action";
        else 
            throw new Exception('Type invlide. La clé action (int) ou son intitulé (string) sont nécessaires pour rechercher une action !');   

        $params = [ "action" => $action ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method search one user in the database
     * @param Int|String $user The user primary key or intitule
     * @return Array
     */ 
    protected function searchUser($user): Array {
        if($user == null)
            throw new Exception("Le nom ou l'identifiant de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");

        // On recherche l'Utilisateur via sont identifiant    
        elseif(is_numeric($user)) {
            // On initialise la requêre
            $request = "SELECT * FROM Utilisateurs WHERE Id_Utilisateurs = :user";
            $params = [
                'user' => $user
            ];
    
            // On lance la requête
            return $this->get_request($request, $params, true, true);

        // On recherche l'utilisateur via son nom      
        } elseif(is_string($user)) {
            // On initialise la requête 
            $request = "SELECT * FROM Utilisateurs WHERE Nom_Utilisateurs = :user";
            $params = [
                'user' => $user
            ];

            // On lance la requête
            return $this->get_request($request, $params, false, true);

        // Sinon    
        } else 
            throw new Exception("Le type n'a pas pu être reconnu. Le nom (string) ou l'identifiant (int) de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");
    }
    /**
     * Protected method searching one user according to his name
     *
     * @param String $user The user name
     * @return Array
     */
    protected function searchUserFromUsername($user): Array {
        if(empty($user) || !is_string($user))
            throw new Exception("Erreur lors de la récupération du nom d'utilisateur");

        // On initialise la requête 
        $request = "SELECT * FROM Utilisateurs WHERE Identifiant_Utilisateurs = :user";
        $params = ['user' => $user];

        // On lance la requête
        return $this->get_request($request, $params, false, true)[0];
    }
    /**
     * Protected method searching one application in the database
     *
     * @param Int $application The application primary key
     * @return Array
     */
    protected function searchCandidature($application): Array {
        // On initialise la requête
        $request = "SELECT * FROM Candidatures WHERE Id_candidatures = :cle";
        $params = ['cle' => $application];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /// Méthode publique recherchant un candidat dans la base de données depuis une de ses candidatures
    /**
     * Public method searching one candidate from one of his application in the database
     *
     * @param Int $cle The application primary key
     * @return Array
     */
    public function searchCandidatFromCandidature($cle): Array {
        // On initialise la requête
        $request = "SELECT * 
        FROM Candidatures 
        INNER JOIN Candidats ON Candidatures.Cle_Candidats = Candidats.Id_Candidats
        WHERE Candidatures.Id_Candidatures = :cle";
        $params = [
            'cle' => $cle
        ];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method searching one candidate from one of his contract in the database
     *
     * @param Int $cle The contract primary key
     * @return Array
     */
    public function searchcandidatFromContrat($cle): Array {
        // On initialise la requête
        $request = "SELECT * 
        FROM Contrats 
        INNER JOIN Candidats ON Contrats.Cle_Candidats = Candidats.Id_Candidats
        WHERE Contrats.Id_Contrats = :cle";
        $params = [
            'cle' => $cle
        ];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one application from his candidate in the database
     *
     * @param Int $cle_candidat The candidate primary key
     * @param Int $cle_instant The instant primary key
     * @return Array
     */
    protected function searchCandidatureFromCandidat($cle_candidat, $cle_instant): Array {
        // On vérifie l'intégrité des données
        if(empty($cle_candidat) || empty($cle_instant)) 
            throw new Exception ('Données éronnées. Pour rechercher une candidatures, lla clé candidat et la clé instant sont nécessaires !');
        
        // On initialise la requête
        $request = "SELECT * FROM candidatures WHERE Cle_Candidats = :candidat AND Cle_Instants = :instant";    
        $params = [
            "candidat" => $cle_candidat,
            "instant" => $cle_instant
        ];

        // On retourne le résultat
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one degree in the database 
     *
     * @param Int|String $diplome The degree primary key or intitule
     * @return Array
     */
    protected function searchDiplome($diplome): Array {
        // Si diplome est un ID
        if(is_numeric($diplome)) {
            // On initialise la requête
            $request = "SELECT * FROM diplomes WHERE Id_Diplomes = :id";
            $params = ["id" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);

        // SI diplome est un intitule    
        } elseif(is_string($diplome)) {
            // On initialise la requête 
            $request = "SELECT * FROM diplomes WHERE Intitule_Diplomes = :intitule";
            $params = ["intitule" => $diplome];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        // En cas d'erreur de typage
        } else 
            throw new Exception("La saisie du diplome est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");        
        
        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one type of contracts in the database 
     *
     * @param Int|String $contrat The types of contracts primary key or intitule
     * @return Array
     */
    protected function searchTypeContrat($contrat): Array {
        // Si contrat est un ID
        if(is_numeric($contrat)) {
            // On initialise la requête
            $request = "SELECT * FROM Types_de_contrats WHERE Id_Types_de_contrats = :id";
            $params = ['id' => $contrat];

        // Si contrat est un intitulé    
        } elseif(is_string($contrat)) {
            // On initialise la requête
            $request =  "SELECT * FROM Types_de_contrats WHERE Intitule_Types_de_contrats = :intitule";
            $params = ['intitule' => $contrat];

        } else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method one source in the database
     *
     * @param Int|String $source The source primary key or intitule
     * @return Array
     */
    protected function searchSource($source): Array {
        // On initialise la requête
        if(is_numeric($source)) {
            $request = "SELECT * FROM sources WHERE Id_Sources = :Id";
            $params = ["Id" => $source];

        } elseif(is_string($source)) {
            $request = "SELECT * FROM sources WHERE Intitule_Sources = :Intitule";
            $params = ["Intitule" => $source];
        } else 
            throw new Exception("La saisie de la source est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    /**
     * Protected method searching one job in the database
     *
     * @param Int|String $job The job primary key or intitule
     * @return Array
     */
    protected function searchPoste($job): Array {
        // On initialise la requête
        if(is_numeric($job)) {
            $request = "SELECT * FROM Postes WHERE Id_Postes = :Id";
            $params = ["Id" => $job];
            
        } elseif(is_string($job)) {
            $request = "SELECT * FROM Postes WHERE Intitule_Postes = :Intitule";
            $params = ["Intitule" => $job];
        } else 
            throw new Exception("Erreur lors de la recherche de poste. La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one service in the database
     *
     * @param Int|String $service The service primary key or intitule
     * @return Array
     */
    protected function searchService($service): Array {
        // Si contrat est un ID
        if(is_numeric($service)) {
            // On initialise la requête
            $request = "SELECT * FROM Services WHERE Id_Services = :id";
            $params = ['id' => $service];

        // Si contrat est un intitulé    
        } elseif(is_string($service)) {
            // On initialise la requête
            $request =  "SELECT * FROM Services WHERE Intitule_Services = :intitule";
            $params = ['intitule' => $service];

        } else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one assistance in the database
     *
     * @param Int|String $aide The assistance primary key or intitule
     * @return Array
     */
    protected function searchAide($aide): Array {
        // Si aide est un ID
        if(is_numeric($aide)) {
            // On initialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Id_Aides_au_recrutement = :id";
            $params = ["id" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true, true);
        
        // Si aide est un intitule    
        } elseif(is_string($aide)) {
            // On intitialise la requête
            $request = "SELECT * FROM Aides_au_recrutement WHERE Intitule_Aides_au_recrutement = :intitule";
            $params = ["intitule" => $aide];

            // On lance la requête
            $result = $this->get_request($request, $params, true);

        } else 
            new Exception("La saisie de l'aide est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");        

        // On retourne le résultat
        return $result;
    }
    /**
     * Protected method searching one Appliquer_a from its application
     *
     * @param Int $cle The application primary key
     * @return Array
     */
    protected function searchAppliquer_aFromCandidature($cle): Array {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Candidatures = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one Appliquer_a from its service
     *
     * @param Int $cle the service primary key
     * @return Array
     */
    protected function searchAppliquer_aFromService($cle): Array {
        // On initialise la requête
        $request = "SELECT * FROM Appliquer_a WHERE Cle_Services = :cle";
        $params = ['cle' => $cle];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one contract in the database
     *
     * @param Int $cle_contrat The contract primary key
     * @return Array
     */
    protected function searchContrat(&$cle_contrat): Array {
        if(empty($cle_contrat) || !is_numeric($cle_contrat))
            throw new Exception('Erreur lors de la recherche du contrat. La clé contrat doit être un nombre entier positif !');

        // On initialise la requête
        $request  = "SELECT * FROM Contrats WHERE Id_Contrats = :cle";
        $params = ['cle' => $cle_contrat];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }
    


    // METHODES D'INSCRIPTION DANS LA BASE DE DONNEES //

    /**
     * protected method registering one user in the database
     *
     * @param Array $user The user's data Array
     * @return Void
     */
    protected function inscriptUtilisateurs($user=[]) {
        if(empty($user)) 
            throw new Exception("Impossible d'inscrire un Utilisateur. Données manquantes !");

        else {
            // On initialise la requête
            $request = "INSERT INTO utilisateurs (identifiant_utilisateurs, nom_utilisateurs, prenom_utilisateurs, email_utilisateurs, motdepasse_utilisateurs, Cle_Etablissements, Cle_Roles)
                        VALUES (:identifiant, :nom, :prenom, :email, :motdepasse, :cle_etablissement, :cle_role)";

            // On lance la requête
            $this->post_request($request, $user);
        }
    }
    /**
     * Protected method registering one action in the database
     *
     * @param Int $cle_user The user's primary key
     * @param Int $cle_action The action primary key
     * @param Int $cle_instant The instant primary key
     * @param String $description The action description
     * @throws Exception If the action's informtions is invalid or no complet
     * @return Void
     */
    protected function inscriptActions(&$key_user, &$key_action, $description=null) {
        try {
            if(empty($key_user) || !is_numeric($key_user))
                throw new Exception("La clé Utilisateur est nécessaire pour l'enregistrement d'une action !");
            elseif(empty($key_action) || !is_numeric($key_action))
                throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        
        if(!empty($description)) {
            $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions, Description) VALUES (:user_id, :type_id, :description)";
            $params = [
                "user_id" => $key_user,
                "type_id" => $key_action,
                'description' => $description
            ];

        } else {
            $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions) VALUES (:user_id, :type_id)";
            $params = [
                "user_id" => $key_user,
                "type_id" => $key_action,
            ];   
        }

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one candidate ine the database
     *
     * @param Candidat $candidat The candidate's data 
     * @return Void
     */
    protected function inscriptCandidat(&$candidat) {
        // On initialise la requête
        if($candidat->getVisite_medicale()) 
            $request = "INSERT INTO Candidats (Nom_Candidats, Prenom_Candidats, Telephone_Candidats, Email_Candidats, 
                Adresse_Candidats, Ville_Candidats, CodePostal_Candidats, Disponibilite_Candidats, VisiteMedicale_Candidats)
                VALUES (:nom, :prenom, :telephone, :email, :adresse, :ville, :code_postal, :disponibilite, :visite)";

        else 
            $request = "INSERT INTO Candidats (Nom_Candidats, Prenom_Candidats, Telephone_Candidats, Email_Candidats, 
                Adresse_Candidats, Ville_Candidats, CodePostal_Candidats, Disponibilite_Candidats)
                VALUES (:nom, :prenom, :telephone, :email, :adresse, :ville, :code_postal, :disponibilite)";

        // On lance  requête
        $this->post_request($request, $candidat->exportToSQL());
    }
    /**
     * Protected method registering one Obtenir in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_diplome The degree primary key
     * @return Void
     */
    protected function inscriptObtenir($cle_candidat, $cle_diplome) {
        // On initialise la requête
        $request = "INSERT INTO obtenir (Cle_Candidats, Cle_Diplomes) VALUES (:candidat, :diplome)";
        $params = [
            "candidat" => $cle_candidat, 
            "diplome" => $cle_diplome
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method regstering one Postuler_a in the database
     *
     * @param Int $candidat The candidate's primary key
     * @param Int $instant The instant primary key
     * @return Void
     */
    protected function inscriptPostuler_a($candidat, $instant) {
        // On initialise la requête 
        $request = "INSERT INTO Postuler_a (Cle_Candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            "candidat" => $candidat, 
            "instant" => $instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Appliquer_a ine the database
     *
     * @param Int $cle_candidature The application primary key
     * @param Int $cle_service The service primary key
     * @return Void
     */
    protected function inscriptAppliquer_a($cle_candidature, $cle_service) {
        // On vérifie l'intégrité des données
        try {
            if(empty($cle_candidature) || empty($cle_service)) 
                throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        
        // On inititalise la requête
        $request = "INSERT INTO Appliquer_a (Cle_Candidatures, Cle_Services) VALUES (:candidature, :service)";
        $params = [
            "candidature" => $cle_candidature,
            "service" => $cle_service
        ];

        // On exécute la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Avoir_droit_a in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_aide The assistance primary key
     * @param Int $cle_coopteur The recommander's primary key
     * @return Void
     */
    protected function inscriptAvoir_droit_a($cle_candidat, $cle_aide, $cle_coopteur=null) {
        if(!empty($cle_coopteur)) {
            // On initialise la requête
            $request = "INSERT INTO Avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement, Cle_Coopteur) VALUES (:candidat, :aide, :coopteur)";
            $params = [
                'candidat' => $cle_candidat,
                'aide' => $cle_aide,
                'coopteur' => $cle_coopteur
            ];

        } else {
            // On initialise la requête
            $request = "INSERT INTO Avoir_droit_a (Cle_Candidats, Cle_Aides_au_recrutement) VALUES (:candidat, :aide)";
            $params = [
                'candidat' => $cle_candidat,
                'aide' => $cle_aide
            ];
        }
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registerin one Proposer_a in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_instant The instant primary key
     * @return Void
     */
    protected function inscriptProposer_a($cle_candidat, $cle_instant) {
        // On initialise la requête
        $request = "INSERT INTO Proposer_a (Cle_candidats, Cle_Instants) VALUES (:candidat, :instant)";
        $params = [
            'candidat' => $cle_candidat,
            'instant' => $cle_instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one mission in the database
     *
     * @param Int $cle_service The sevice primary key
     * @param Int $cle_poste The job primary key
     * @return Void
     */
    protected function inscriptMission($cle_service, $cle_poste) {
        // On intitialise la requête 
        $request = "INSERT INTO Missions (Cle_Services, Cle_Postes) VALUES (:cle_service, :cle_poste)";
        $params = [
            "cle_service" => $cle_service,
            "cle_poste" => $cle_poste
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one meeting in the database 
     *
     * @param Int $cle_utilisateur The user's primary key (recruiter) 
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_etablissement The establishment primary key
     * @param Int $cle_instants The instant primary key
     * @return Void
     */
    protected function inscriptAvoir_rendez_vous_avec($cle_utilisateur, $cle_candidat, $cle_etablissement, $cle_instants) {
        // On intitialise la requête 
        $request = "INSERT INTO Avoir_rendez_vous_avec (Cle_Utilisateurs, Cle_Candidats, Cle_Etablissements, Cle_Instants) VALUES (:cle_utilisateurs, :cle_candidats, :cle_etablissements, :cle_instants)";
        $params = [
            ":cle_utilisateurs" => $cle_utilisateur, 
            ":cle_candidats" => $cle_candidat, 
            ":cle_etablissements" => $cle_etablissement, 
            ":cle_instants" => $cle_instants
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one job in the database
     *
     * @param String $poste The job intitule
     * @param String $description The job description
     * @return Void
     */
    protected function inscriptPoste(&$poste, &$description) {
        // On initialise la requête
        $request = "INSERT INTO Postes (Intitule_Postes, Description_Postes) VALUES (:poste, :description)";
        $params = [
            "poste" => $poste,
            "description" => $description
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one service in the database
     *
     * @param String $service The service intitule
     * @param String $cle_etablissement The service description
     * @return Void
     */
    protected function inscriptService(&$service, $cle_etablissement) {
        // On initialise la requête 
        $request = "INSERT INTO Services (Intitule_Services, Cle_Etablissements) VALUES (:service, :etablissement)";
        $params = [
            'service' => $service,
            'etablissement' => $cle_etablissement
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one establishment
     *
     * @param Array<String> $infos The establishment data Array 
     * @return Void
     */
    protected function inscriptEtablissement(&$infos=[]) {
        // On initialise la requête 
        $request = "INSERT INTO Etablissements (Intitule_Etablissements, Adresse_Etablissements, Ville_Etablissements, CodePostal_Etablissements, Cle_Poles) 
        VALUES (:intitule, :adresse, :ville, :code, :pole)";
        $params = [
            'intitule' => $infos['intitule'],
            'adresse' => $infos['adresse'],
            'ville' => $infos['ville'],
            'code' => $infos['code postal'],
            'pole' => $infos['pole']
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one hub in the database
     *
     * @param String $intitule The hub intitule
     * @param String $description The hub description
     * @return Void
     */
    protected function inscriptPole(&$intitule, &$description) {
        // On initialise la requête 
        $request = "INSERT INTO Poles (Intitule_Poles, Description_Poles) VALUES (:intitule, :desc)";
        $params = [
            'intitule' => $intitule,
            'desc' => $description
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one degree in the database
     *
     * @param String $diplome The degree intitule
     * @return Void
     */
    protected function inscriptDiplome($diplome) {
        // On initialise la requête
        $request = "INSERT INTO Diplomes (Intitule_Diplomes) VALUES (:intitule)";
        $params = ["intitule" => $diplome];

        // On lance la requête
        $this->post_request($request, $params);
    }


    // METHODES DE MISE-A-JOUR // 

    /**
     * Public method updating one user's password 
     *
     * @param String $password The new user's password
     * @return Void
     */
    public function updatePassword(&$password) {
        // On initialise la requête
        $request = "UPDATE Users
        SET Password = :password, PasswordTemp = false
        WHERE Id = :key";
        $params = [
            'key' => $_SESSION['user_key'],
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one user's data
     *
     * @param Int $cle_utilisateur The user's primary key
     * @param Array<String> $user The user's data Array
     * @return Void
     */
    public function updateUser($cle_utilisateur, $user=[]) {
        // On initialise la requête
        $request = "UPDATE Utilisateurs 
        SET Nom_Utilisateurs = :nom, Prenom_Utilisateurs = :prenom, Email_Utilisateurs = :email, Cle_Roles = :role
        WHERE Id_Utilisateurs = :cle";
        $params = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
            'cle' => $cle_utilisateur
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /**
     * public method updating one candidate's evaluation
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Array $notation The candidate's data Array
     * @return Void
     */
    public function updateNotation($cle_candidat, &$notation=[]) {
        // On initialise la requête
        $request = "UPDATE Candidats 
        SET Notations_Candidats = :notation, Descriptions_Candidats = :description, A_candidats = :a, B_Candidats = :b, C_Candidats = :c
        WHERE Id_Candidats = :cle";
        $params = [
            'notation' => $notation['notation'],
            'description' => $notation['description'],
            'a' => $notation['a'],
            'b' => $notation['b'],
            'c' => $notation['c'],
            'cle' => $cle_candidat
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating a candidate's data
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Array<String> $candidat The cadidate's data Array
     * @return Void
     */
    public function updateCandidat($cle_candidat, $candidat=[]) {
        // On initialise la requête
        $request = "UPDATE Candidats 
        SET Nom_candidats = :nom, Prenom_Candidats = :prenom, Email_Candidats = :email, Telephone_Candidats = :telephone, Adresse_Candidats = :adresse, Ville_Candidats = :ville, CodePostal_Candidats = :code_postal
        Where Id_Candidats = :cle";
        $params = [
            'nom' => $candidat['nom'], 
            'prenom' => $candidat['prenom'], 
            'email' => $candidat['email'], 
            'telephone' => $candidat['telephone'], 
            'adresse' => $candidat['adresse'], 
            'ville' => $candidat['ville'], 
            'code_postal' => $candidat['code_postal'],
            'cle' => $cle_candidat
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one candidate's meeting
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_utilisateur The user's primary key
     * @param Int $cle_instant The instant primary key
     * @param Array $rdv The metting data Array
     * @return Void
     */
    public function updateRendezVous($cle_candidat, $cle_utilisateur, $cle_instant, &$rdv=[]) {
        // On met-à-jour l'utilisateur
        $request = "UPDATE Avoir_rendez_vous_avec
        SET Cle_utilisateurs = :user, Cle_Etablissements = :etablissement
        WHERE Cle_Candidats = :candidat AND Cle_utilisateurs = :utilisateur AND Cle_Instants = :instant";
        $params = [
            'user' => $this->searchUserFromUsername($rdv['recruteur'])['Id_Utilisateurs'],
            'etablissement' => $this->searchEtablissement($rdv['etablissement'])['Id_Etablissements'],
            'candidat' => $cle_candidat,
            'utilisateur' => $cle_utilisateur,
            'instant' => $cle_instant 
        ];
        $this->post_request($request, $params);

        // On met-à-jour la date et l'heure
        $request = "UPDATE Instants
        SET Jour_Instants = :date, Heure_Instants = :time";
        $params = [
            'date' => $rdv['date'],
            'time' => $rdv['time']
        ];
        $this->post_request($request, $params);
    }


    // METHODES DE SUPPRESSION //

    /**
     * Protected method deleting one meeting
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_utilisateur The use's primary key
     * @param Int $cle_instant The instant primary key
     * @return Void
     */
    protected function deleteRendezVous($cle_candidat, $cle_utilisateur, $cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Avoir_rendez_vous_avec
        WHERE Cle_Candidats = :candidat
        AND Cle_Utilisateurs = :utilisateur
        AND Cle_Instants = :instant";
        $params = [
            'candidat' => $cle_candidat,
            'utilisateur' => $cle_utilisateur,
            'instant' => $cle_instant
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method deleting one instant
     *
     * @param Int $cle_instant The instant primary key
     * @return Void
     */
    protected function deleteInstant($cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On lance la requête
        $this->post_request($request, $params);
    }
}