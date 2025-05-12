<?php

namespace App\Core\Tools\FileManager;

use \Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Core\Tools\FileManager;
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
     * Protected attribute containing the FileInterpreter wich analizes data
     *
     * @var FileInterpreter
     */
    protected FileInterpreter $interpreter;

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

    /**
     * Public method returning the FileInterpreter
     *
     * @return FileInterpreter
     */
    public function getInterpreter(): FileInterpreter { return $this->interpreter; }

    /**
     * Public static method returning the based path for logs of registerings
     *
     * @return string
     */
    public static function getBasedRegistersLogsPath(): string { return "./database/logs/registerings_logs.xlsx"; }
    /**
     * Public static method returning the based path for logs of errors
     *
     * @return string
     */
    public static function getBasedErrorsLogsPath(): string { return "./database/logs/errors_logs.xlsx"; }


    // * READ * //
    /**
     * Public method reading a file
     *
     * @return void
     */
    public function readFile() {
        $file = IOFactory::load($this->getPath());                                                      // Loading the file
        $sheet = $file->getSheet($this->getPage());                                                     // Loading the page
        $size = $sheet->getHighestRow();

        $this->getLogsRegister()->printRow(1, Registering::toXlsx());                                   // Writing the header

        $rowStructure = (array) $this->readLine($sheet, 1);                                             // Reading header
        $this->interpreter = new FileInterpreter($rowStructure);

        $resgister_row = 2;
        $err_row = 1;
        for($rowCount = 2; $rowCount <= $size; $rowCount++) {                                           // Reading the file
            $registering = new Registering();

            $rowData = (array) $this->readLine($sheet, $rowCount);

            if(!$this->isEmptyRow($rowData)) try {
                $this->getInterpreter()->rowAnalyse($registering, $rowData);                           // Analyzing the row

                echo "On a enregistré la ligne : ";
                print_r($registering);
                echo "<br>";

                $this->getLogsRegister()->printRow($resgister_row, $registering->toArray());           // Writing the registration 
                $resgister_row++;

            } catch(Exception $e) {
                $rowData["Erreur"] = get_class($e);
                $rowData["Erreur description"] = $e->getMessage();

                echo "Erreur : " . $e->getMessage() . "<br>";
                echo "On supprime : ";
                print_r($registering);
                echo "<br><br>";

                $this->getInterpreter()->deleteRegistering($registering);                               // Deleting incompleted data

                if($err_row == 1) {
                    array_push($rowStructure, "Erreur");
                    array_push($rowStructure, "Erreur description");

                    $this->getErrorsRegister()->printRow($err_row, $rowStructure);
                    $err_row++;
                }

                $this->getErrorsRegister()->printRow($err_row, $rowData);                               // Registering the erreors logs
                $err_row++;
            }

            unset($registering);
        }

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
            if(! is_null($row[$i]) || !empty($row[$i])) {
                $empty = false;
            }

            $i++;
        }

        return $empty;
    }

    /**
     * Protected method registering the changements with FilePrinters
     *
     * @return void
     */
    protected function saveWork() {
        $this->getLogsRegister()->save();

        $this->getErrorsRegister()->save();
    }
}
