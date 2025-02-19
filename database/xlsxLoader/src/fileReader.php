<?php

namespace DB;

use \Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class reading a file 
 */
class fileReader {
    /**
     * Protected attribute containing the filePrinter writing the logs of registerings
     *
     * @var filePrinter
     */
    protected filePrinter $logsRegister;
    /**
     * Protected attribute containing the filePrinter writing the logs of errors
     *
     * @var filePrinter
     */
    protected filePrinter $errorsRegister;

    /**
     * Constructor class
     *
     * @param string $filePath The path of the file 
     * @param int $page The index of the page
     * @param ?string $registerLogsPath The path of the logs of registerings
     * @param ?string $errorsLogsPath The path of the errors logs
     */
    public function __construct(
        protected string $filePath,
        protected int $page, 
        ?string $registerLogsPath = null,
        ?string $errorsLogsPath = null
    ) {
        echo "<h1>Nouveau fileReader</h1>";

        if($page < 0) {
            die("Il est impossble de lire une feuille d'indice négatif");
        }


        $this->logsRegister = new filePrinter($registerLogsPath ?? fileReader::getBasedRegistersLogsPath());

        $this->errorsRegister = new fileprinter($errorsLogsPath ?? fileReader::getBasedErrorsLogsPath());
    }


    // * GET * //
    /**
     * Public method returning the path of file
     *
     * @return string The path
     */
    public function getPath(): string { return $this->filePath; }

    /**
     * Public method returning the index of the page
     *
     * @return int The index
     */
    public function getPage(): int { return $this->page; }

    /**
     * Public method returning the fileprinter for registerings
     *
     * @return filePrinter
     */
    public function getLogsRegister(): filePrinter { return $this->logsRegister; }
    /**
     * public method returning the filePrinter for errors
     *
     * @return filePrinter
     */
    public function getErrorsRegister(): filePrinter { return $this->errorsRegister; }

    /**
     * Public static method returning the based path for logs of registerings
     *
     * @return string
     */
    public static function getBasedRegistersLogsPath(): string { return "./logs/registerings_logs.xlsx"; }
    /**
     * Public static method returning the based path for logs of errors
     *
     * @return string
     */
    public static function getBasedErrorsLogsPath(): string { return "./logs/errors_logs.xlsx"; }


    // * READ * //
    /**
     * Public method reading a file
     *
     * @return void
     */
    public function readFile() {
        echo "<h2>On débute la procédure</h2>";

        $file = IOFactory::load($this->getPath());                                                  // Loading the file


        $file_name = $this->getpath();
        
        echo "<h3>Fichier : {$file_name} ouvert</h3>";


        $sheet = $file->getSheet($this->getPage());                                                 // Loading the page
        
        echo "<h3>Page sélectionnée</h3>";


        $size = $sheet->getHighestRow();

        echo "{$size} lignes trouvées<br>";

        echo "<h3>On débute la lecture</h3>";


        $rowStructure = $this->readLine($sheet, 1);

        $err_row = 1;

        for($rowCount = 2; $rowCount <= $size; $rowCount++) {                                       // Reading the file
            $rowData = (array) $this->readLine($sheet, $rowCount);

            if(! $this->isEmptyRow($rowData)) try {
                echo "<h4>Ligne : {$rowCount}</h4>";

                print_r($rowData);

                $this->getLogsRegister()->printRow($rowCount - 1, $rowData);

            } catch(Exception $e) {
                $rowData["Erreur"] = get_class($e);

                $rowData["Erreur description"] = $e->getMessage();


                $this->getErrorsRegister()->printRow($err_row, $rowData); 

                $err_row++;
            }
        }


        echo "<h3>Lecture terminée</h3>";


        $this->saveWork();
    }

    /**
     * Protected method reading a line of the Excel 
     *
     * @param $sheet The file to read
     * @param int $row The index of the row
     * @return void
     */
    protected function readLine($sheet, int $row) {
        $rowData = [];

        $cellIterator = $sheet->getRowIterator($row)->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); 

        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
        }

        return $rowData;
    }

    // * OTHER * //
    /**
     * Peotected method testing if a row is empty or not
     *
     * @param array $row The rom
     * @return boolean 
     */
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

    /**
     * Protected method registering the changements with fileprinters
     *
     * @return void
     */
    protected function saveWork() {
        echo "<h2>On enregistre</h2>";

        echo "<h3>Les logs</h3>";

        $this->getLogsRegister()->save();

        echo "<h3>Les erreurs</h3>";

        $this->getErrorsRegister()->save();

        echo "<h2>Terminé</h2>";
    }
}
