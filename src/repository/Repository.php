<?php 

namespace App\Repository;

use \PDO;
use \Exception;
use \PDOException;
use App\Core\Database;
use App\Core\Tools\AlertsManip;

/**
 * Abstract class representing a basic repository
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Repository {
    /**
     * Private attribute containing the database connection
     * 
     * @var PDO
     */
    private $connection;

    /**
     * Class' constructor
     */
    public function __construct() { $this->connection = Database::getInstance()->getConnection(); }


    // * GET * //
    /**
     * Protected method returning the database connection
     */
    protected function getConnection() { return $this->connection; }
    
    // * REQUEST * //
    /**
     * Private method executing a GET request to the database
     *
     * @param string $request The SQL request
     * @param array<string> $params The request data parameters
     * @param boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @throws Exception
     * @return array
     */
    protected function get_request(
        string $request, 
        ?array $params = [], 
        bool $unique = false,
        bool $present = false
    ): array { 
        try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);
            $result = $unique ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC);
            $query->closeCursor();

            if(!$result && $present) {
                throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
            }

            return $result;

        } catch(Exception $e){
            $class = get_class($e);
            throw new $class("Erreur lors de la requête à la base de données : " . $e->getMessage());

            // AlertsManip::error_alert([
            //     'title' => 'Erreur lors de la requête à la base de données',
            //     'msg' => $e
            // ]);
            // return null;
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
            AlertsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
            return -1;
        }
    }
}