<?php

require_once("../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once('../define.php');

class sqlInserter {
    protected $connection;

    public function __construct() { $this->connect(); }

    protected function connect() {
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

    protected function getConnection() { return $this->connection; }

    protected function post_request(string &$request, array &$params) {
        try {
            $query = $this->getConnection()->prepare($request);

            $query->execute($params);

            $lastId = $this->getConnection()->lastInsertId();

            return $lastId;

        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        }
    }
}

class fileReader {
    public function __construct(
        protected string $file_path,
        protected int $page
    ) {
        if($page < 0) {
            die("Il est impossble de lire une feuille d'indice négatif");
        }
    }

    public function getPath(): string { return $this->file_path; }

    public function getPage(): int { return $this->page; }

    public function readFile() {
        echo "On débute la procédure<br>";

        $file = IOFactory::load($this->getPath());                                                  // Loading the file

        echo "Fichier ouvert<br>";

        $sheet = $file->getSheet($this->getPage());                                                 // Loading the page
        
        echo "Page sélectionnée<br>";

        $size = $sheet->getHighestRow();

        echo "{$size} lignes trouvées<br>";

        echo "On débute la lecture<br>";

        for($row = 1; $row <= $size; $row++) {
            $this->readLine($sheet, $row);
        }
    }

    protected function readLine($sheet, int $row) {
        $rowData = [];

        $cellIterator = $sheet->getRowIterator($row)->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); 

        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
        }

        if(! $this->isEmptyRow($rowData)) {
            var_dump($rowData);
            echo "<br>";
        }
    }

    protected function isEmptyRow(array $row): bool {
        $i = 0;

        $empty = true;

        $size = count($row);

        while($empty && $i < $size) {
            if(! is_null($row[$i]) || ! empty($row[$i])) {
                $empty = false;
            }

            $i++;
        }

        return $empty;
    }
}

function main() {
    $file_reader = new fileReader("pole_recrutement_donnees.xlsx", 0);

    $file_reader->readFile();
}

main();