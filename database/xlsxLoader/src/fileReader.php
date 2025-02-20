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
     * Protected attribute containing the sqlInterpreter wich analizes data
     *
     * @var sqlInterpreter
     */
    protected sqlInterpreter $interpreter;

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
     * Public method returning the sqlInterpreter
     *
     * @return sqlInterpreter
     */
    public function getInterpreter(): sqlInterpreter { return $this->interpreter; }

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
        $file = IOFactory::load($this->getPath());                                                      // Loading the file
        $sheet = $file->getSheet($this->getPage());                                                     // Loading the page
        $size = $sheet->getHighestRow();

        $this->getLogsRegister()->printRow(1, Registering::toXlsx());                                   // Writing the header

        $rowStructure = (array) $this->readLine($sheet, 1);                                             // Reading header
        $this->interpreter = new sqlInterpreter($rowStructure);


        $err_row = 1;
        for($rowCount = 2; $rowCount <= $size; $rowCount++) {                                           // Reading the file
            $rowData = (array) $this->readLine($sheet, $rowCount);

            if(! $this->isEmptyRow($rowData)) try {
                $registering = $this->getInterpreter()->rowAnalyse($rowData);                           // Analyzing the row
                // todo : $registering->toArray());
                $this->getLogsRegister()->printRow($rowCount, $registering->toArray());                 // Writing the registration 

            } catch(Exception $e) {
                $rowData["Erreur"] = get_class($e);
                $rowData["Erreur description"] = $e->getMessage();

                if($err_row == 1) {
                    array_push($rowStructure, "Erreur");
                    array_push($rowStructure, "Erreur description");

                    $this->getErrorsRegister()->printRow($err_row, $rowStructure);

                    $err_row++;
                }

                $this->getErrorsRegister()->printRow($err_row, $rowData); 

                $err_row++;
            }
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
        $this->getLogsRegister()->save();

        $this->getErrorsRegister()->save();
    }
}
