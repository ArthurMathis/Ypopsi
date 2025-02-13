<?php 

namespace App\Repository;

use \PDO;
use \PDOException;
use \Exception;
use App\Core\FormsManip;

/**
 * Abstract class representing a basic repository
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Repository {
    /**
     * Private attribute containing the database connection
     */
    private $connection;

    /**
     * Class' constructor
     */
    public function __construct() { $this->makeConnection(); }


    // * GET * //
    /**
     * Protected method returning the database connection
     */
    protected function getConnection() { return $this->connection; }


    // * MAKE * //
    /**
     * Protected method connecting the application to the database
     * 
     * @return PDO The connection at the database
     */
    protected function makeConnection(): PDO {
        try {
            $db_connection  = getenv('DB_CONNEXION');
            $db_host        = getenv('DB_HOST');
            $db_port        = getenv('DB_PORT');
            $db_name        = getenv('DB_NAME');
            $db_user        = getenv('DB_USER');
            $db_password    = getenv('DB_PASS');
    
            $db_host = str_replace('/', '', $db_host);
    
            $db_fetch = "$db_connection:host=$db_host;port=$db_port;dbname=$db_name";

            $this->connection = new PDO($db_fetch, $db_user, $db_password, Array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            die("Connexion à la base de données réchouée. " . $e->getMessage());
        }
        return $this->connection;
    }

    
    // * REQUEST * //
    /**
     * Private method executing a GET request to the database
     *
     * @param string $request The SQL request
     * @param array<string> $params The request data parameters
     * @param boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return ?array
     */
    protected function get_request(string $request, ?array $params = [], bool $unique = false, bool $present = false): ?array { 
        if(empty($unique) || empty($present)) {
            $present = false;
        }

        try {
            $query = $this->getConnection()->prepare($request);

            $query->execute($params);

            $result = $unique ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result) && $present) {
                throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
            } else {
                return $result;
            }
    
        } catch(Exception $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } catch(PDOException $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        }
    }
    /**
     * Private method executing a POST request to the database
     *
     * @param string $request The SQL request
     * @param array  $params The request data Array
     * @return int The primary key og the new element
     */
    protected function post_request(string $request, array $params): int {
        try {
            $query = $this->getConnection()->prepare($request);

            $query->execute($params);

            $lastId = $this->getConnection()->lastInsertId();

            return $lastId;
    
        } catch(PDOException $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        }
    }
}