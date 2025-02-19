<?php

namespace DB;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class writing in a file
 */
class filePrinter {
    /**
     * Protected attribute containing the file
     *
     * @var Spreadsheet
     */
    protected Spreadsheet $sheet; 
    /**
     * Protected attribute containing the writer
     *
     * @var Xlsx
     */
    protected Xlsx $writer; 

    /**
     * Constructor class 
     *
     * @param string $path The path of the file
     */
    public function __construct(protected string $path) {
        echo "<h2>Nouveau filePrinter</h2>";

        if(file_exists($this->getPath())) {
            $this->sheet = IOFactory::load($this->getpath());                   // Opening the file
        } else {
            $this->sheet = new Spreadsheet();                                   // Creating new file
        }

        echo "<h3>Fichier {$this->path} ouvert</h3>";


        $this->writer = new Xlsx($this->getSheet());                            // Opening the writer

        echo "<h3>Nouveau writer ouvert</h3>";


        $title = $title = "Insertion du " . date('d/m/Y');

        $title = $this->addSheet($title);                                                // Creating the new sheet 

        echo "<h3>Nouvelle page : {$title} prête</h3>";
    }

    // * GET * //
    /**
     * Public method returning the path of the file
     *
     * @return string
     */
    public function getPath(): string { return $this->path; }
    /**
     * Public method returning the file
     *
     * @return Spreadsheet
     */
    public function getSheet(): Spreadsheet { return $this->sheet; }
    /**
     * Public method returning the writer
     *
     * @return Xlsx
     */
    public function getWriter(): Xlsx { return $this->writer; }

    /**
     * Public static method returning the based position of a new sheet
     *
     * @return int The index
     */
    public static function getBasedSheet(): int { return 0; }
    /**
     * Public static method returning the based column of the sheet
     *
     * @return string
     */
    public static function getBasedColumn(): string { return "A"; }

    // * PRINT * //
    /**
     * Public method writing a row in the file
     *
     * @param int $row The index og the row
     * @param array $data The data to write
     * @return void
     */
    public function printRow(int $row, array &$data) {
        $sheet = $this->getSheet()->getActiveSheet();

        $column = filePrinter::getBasedColumn();

        foreach($data as $obj) {
            $sheet->setCellValue($column . $row, $obj);

            $column++;
        }
    }

    // * MANIPULATION * //
    /**
     * Public method registering the modifications
     *
     * @return void
     */
    public function save() { $this->getWriter()->save($this->getPath()); }

    /**
     * Protected method adding a new Sheet in the file
     *
     * @param string $sheetname The title of the sheet
     * @return void
     */
    protected function addSheet(string $sheetname): string {
        $sheetname = str_replace("/", "-", $sheetname);

        $sheetname = preg_replace('/[\\/?*:[]"<>|]/', ' ', $sheetname);

        $sheetname = substr($sheetname, 0, 31);


        var_dump($sheetname); 
        echo "<br>";


        $worksheet = new Worksheet($this->getSheet(), $sheetname);                                          // Creating the new sheet

        $this->getSheet()->addSheet($worksheet);                                                            // Adding the new sheet

        $this->getSheet()->getSheet(filePrinter::getBasedSheet())->setTitle($sheetname);                    // Setting the title 


        return $sheetname;
    }
}