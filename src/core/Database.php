<?php

namespace App\Core;

use \PDO;
use \PDOException;

/**
 * Class containing the database connection
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Database {
    /**
     * Portected attribute containing the database instance
     *
     * @var Database
     */
    protected static $instance = null;
    /**
     * Protected attribute containing the database connection
     *
     * @var PDO
     */
    protected PDO $connection;
    
    // ** CONSTRUCTOR ** //
    /**
     * Class' constructor
     */
    protected function __construct() {
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
    }

    // * GET * //
    /**
     * Public method returning the database connection
     *
     * @return PDO
     */
    public function getConnection(): PDO { return $this->connection; }

    /**
     * Public static method returning the instance of the Database connexion
     *
     * @return Database
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}