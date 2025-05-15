<?php

namespace App\Core\Tools\FileManager;

use \Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Core\Tools\Registering;

/**
 * Class reading a file 
 */
class FileReader {
    /**
     * Protected attribute containing the FilePrinter writing the logs of registerings
     *
     * @var FilePrinter
     */
    protected FilePrinter $logsRegister;
    /**
     * Protected attribute containing the FilePrinter writing the logs of errors
     *
     * @var FilePrinter
     */
    protected FilePrinter $errorsRegister;

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
        protected int $page = 0, 
        ?string $registerLogsPath = null,
        ?string $errorsLogsPath = null
    ) {
        if($page < 0) {
            die("Il est impossble de lire une feuille d'indice négatif");
        }

        $this->logsRegister = new FilePrinter($registerLogsPath ?? FileReader::getBasedRegistersLogsPath());
        $this->errorsRegister = new FilePrinter($errorsLogsPath ?? FileReader::getBasedErrorsLogsPath());
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

    //// FILE MANAGER ////
    /**
     * Public method returning the FilePrinter for registerings
     *
     * @return FilePrinter
     */
    public function getLogsRegister(): FilePrinter { return $this->logsRegister; }
    /**
     * public method returning the FilePrinter for errors
     *
     * @return FilePrinter
     */
    public function getErrorsRegister(): FilePrinter { return $this->errorsRegister; }

    //// BASED DATA ////
    public static function getBasedBatchCount(): int { return 1; }
    /**
     * Public static method returning the based path for the file
     *
     * @return string
     */
    public static function getBasedLogsPath(): string { return "./database/logs"; }
    /**
     * Public static method returning the based path for logs of registerings
     *
     * @return string
     */
    public static function getBasedRegistersLogsPath(): string { return FileReader::getBasedLogsPath() . "/registerings_logs.xlsx"; }
    /**
     * Public static method returning the based path for logs of errors
     *
     * @return string
     */
    public static function getBasedErrorsLogsPath(): string { return FileReader::getBasedLogsPath() . "/errors_logs.xlsx"; }


    // * READ * //
    /**
     * Public method reading a file
     *
     * @return void
     */
    public function readFile(string $type = "Xlsx") {
        $reader = IOFactory::createReader($type);                                                           // Creating the reader
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false); 
        $file = $reader->load($this->getPath());                                                            // Loading the file

        try {
            $sheet = $file->getSheet($this->getPage());                                                     // Loading the page
            $file_size = $sheet->getHighestRow();

            $row_structure = (array) $this->readLine($sheet, 1);                                            // Reading header

            $batch_file = [];
            for($row_count = 2; $row_count <= $file_size; $row_count++) {                                   // Reading the file
                $row_data = (array) $this->readLine($sheet, $row_count);
                array_push($batch_file, $row_data);
            }

        } finally {
            if (isset($file)) {                                                                             // Close the file and remove the cache
                $file->disconnectWorksheets();
                unset($file);
                gc_collect_cycles();
            }
        }

        $registers_logs = [];
        $errors_logs = [];
        $resgister_row = FileReader::getBasedBatchCount();
        $error_row = FileReader::getBasedBatchCount();

        $interperter = new FileInterpreter($row_structure);
        array_push($row_structure, "Erreur");
        array_push($row_structure, "Erreur description");

        foreach(array_chunk($batch_file, getenv("FILE_CACHE_SIZE")) as $batch) {                            // Analyse data
            $this->processBatch($interperter, $batch, $registers_logs, $errors_logs);

            if(!empty($registers_logs)) {
                $registering_structure = Registering::toXlsx();
                $this->writeRegistersLogs($registers_logs, $resgister_row, $registering_structure);
            }
            
            if(!empty($errors_logs)) {
                $this->writeErrorsLogs($errors_logs, $error_row, $row_structure);
            }
        }

        return [
            "registerings" => $resgister_row - 2,
            "errors"       => $error_row - 2,
        ];
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
            $temp = $cell->getValue();
            $rowData[] = isset($temp) ? trim($temp) : null;
        }

        return $rowData;
    }

    /**
     * Protected function that analyse the file's pieces of data, register it ine the data base and save these logs
     *
     * @param FileInterpreter $interpreter The FileInterpreter that read and analyse the file content
     * @param array $batch_file The file's content 
     * @param array $registers_logs The array that is gonna to contain the registers logs
     * @param array $errors_logs The array that is gonna to contain the errors logs
     * @return void
     */
    protected function processBatch(FileInterpreter &$interpreter, array &$batch_file, array &$registers_logs, array &$errors_logs): void {
        foreach($batch_file as $obj) {
            try {
                $registering = new Registering();
                $interpreter->rowAnalyse($registering, $obj);                                // Analyzing the row

                echo "Nouveau candidat généré : ";
                var_dump($registering);
                echo "<br>";
                
                array_push($registers_logs, $registering);

            } catch(Exception $e) {
                $obj["Erreur"] = get_class($e);
                $obj["Erreur description"] = $e->getMessage();

                echo "Nouvelle erreur générée<br>";

                array_push($errors_logs, $obj);

                $interpreter->deleteRegistering($registering);                               // Deleting incompleted data
            }
        }

        echo "<h2>Bilan</h2>";
        $registerins_count = count($registers_logs);
        echo "<h3>Enregistrements valides : $registerins_count</h3>";
        $errors_count = count($errors_logs);
        echo "<h3>Enregistrements invalides : $errors_count</h3>";
        echo "<br>";
    }

    // * WRITE * //
    /**
     * Protected static method that write an action in a log 
     *
     * @param FilePrinter $printer The FilePrinter that writes
     * @param array $log The action to write
     * @param integer $row_count The row in which to write
     * @return void
     */
    static protected function writeLogs(FilePrinter &$printer, array &$log, int &$row_count): void {
        $printer->printRow($row_count, $log);
        unset($log);
        $row_count++;
    }

    /**
     * Protected method that write the registrations in the logs
     *
     * @param array $registers The registrations the save 
     * @param integer $row_count The row in which to write
     * @param array $row_structure The table header
     * @return void
     */
    protected function writeRegistersLogs(array &$registers, int &$row_count, array &$row_structure): void {
        echo "<h2>On enregistre les logs de réussites</h2>";

        $printer = $this->getLogsRegister();
        if($row_count == FileReader::getBasedBatchCount()) {
            echo "<h3>On enregistre l'entête de fichier</h3>";
            FileReader::writeLogs($printer, $row_structure, $row_count);
        }

        foreach($registers as $obj) {
            $temp = $obj->toArray();
            echo "On inscript la <b>$row_count</b>ème ligne : ";
            var_dump($temp);
            echo "<br>";
            FileReader::writeLogs($printer, $temp, $row_count);
        }

        $registers = [];
        $this->getLogsRegister()->save();
        echo "<h2>Logs enregistrés</h2>";
    }
    /**
     * Protected method that write the failures in the logs
     *
     * @param array $errors The failures the save 
     * @param integer $row_count The row in which to write
     * @param array $row_structure The table header
     * @return void
     */
    protected function writeErrorsLogs(array &$errors, int &$row_count, array &$row_structure): void {
        echo "<h2>On enregistre les logs d'échecs</h2>";

        $printer = $this->getErrorsRegister();
        if($row_count == FileReader::getBasedBatchCount()) {
            echo "<h3>On enregistre l'entête de fichier</h3>";
            FileReader::writeLogs($printer, $row_structure, $row_count);
        }

        foreach($errors as $obj) {
            FileReader::writeLogs($printer, $obj, $row_count);
        }

        $errors = [];
        $this->getErrorsRegister()->save();
        echo "<h2>Logs enregistrés</h2>";
    }


    // * TOOLS * //
    /**
     * Peotected method testing if a row is empty or not
     *
     * @param array $row The rom
     * @return boolean 
     */
    protected function isEmptyRow(array &$row): bool {
        $i = 0;
        $empty = true;
        $size = count($row);
        while($empty && $i < $size) {
            if(! is_null($row[$i]) || !empty($row[$i])) {
                $empty = false;
            }

            $i++;
        }

        return $empty;
    }
}
