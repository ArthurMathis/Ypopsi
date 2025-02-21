<?php

namespace DB\SqlManip;

use \PDO;
use \PDOException;
use \Exception;

/**
 * Class manipulating the database connection
 * 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class sqlInserter {
    /**
     * Protected attribute containing the connection to the database
     *
     * @var PDO
     */
    protected $connection;

    /**
     * Constructor class
     */
    public function __construct() { $this->connect(); }

    /**
     * Protected method making the connection
     *
     * @throws PDOExceptions If the connection failed
     * @return PDO
     */
    protected function connect(): PDO {
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
            die("Connexion à la base de données échouée. " . $e->getMessage());
        }

        return $this->connection;
    }

    // * GET * //
    /**
     * Protected method returning the connection
     *
     * @return PDO
     */
    protected function getConnection(): PDO { return $this->connection; }

    /**
     * Public method making a post request at the database
     *
     * @param string $request The request
     * @param array $params The params of the request
     * @return int The primary key of the new registration
     */
    public function post_request(string &$request, array &$params): int {
        var_dump($request); 
        echo "<br>";
        var_dump($params);
        echo "<br><br>";

        $query = $this->getConnection()->prepare($request);

        $query->execute($params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Public method executing a GET request to the database
     *
     * @param string $request The SQL request
     * @param array $params The request data parameters
     * @param bool $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param bool $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return ?array
     */
    public function get_request(string $request, ?array $params = [], bool $unique = false, bool $present = false): ?array { 
        if(empty($unique) || empty($present)) {
            $present = false;
        }

        $query = $this->getConnection()->prepare($request);

        $query->execute($params);

        $result = $unique ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC);

        if(empty($result)) {
            if($present) {
                throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
            } else {
                return null;
            } 
        } else {
            return $result;
        }

        return null;
    }
}
