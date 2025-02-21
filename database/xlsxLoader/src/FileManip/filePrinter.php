<?php

namespace DB\FileManip;

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
        if(file_exists($this->getPath())) {
            $this->sheet = IOFactory::load($this->getpath());                           // Opening the file
        } else {
            $this->sheet = new Spreadsheet();                                           // Creating new file
        }

        $this->writer = new Xlsx($this->getSheet());                                    // Opening the writer

        $title = "Insertion du " . date('d/m/Y');
        $title = $this->addSheet($title);                                                // Creating the new sheet 
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
    public function printRow(int $row, array $data) {
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

        $originalSheetname = $sheetname;
        $index = 1;

        while ($this->sheetNameExists($sheetname)) {
            $sheetname = substr($originalSheetname, 0, 31 - strlen(" - $index")) . " - $index";
            $index++;
        }

        $worksheet = new Worksheet($this->getSheet(), $sheetname);                                                      // Creating the new sheet
        $this->getSheet()->addSheet($worksheet);                                                                        // Adding the new sheet
        $worksheet->setTitle($sheetname);                                                                               // Setting the title

        return $sheetname;
    }

    /**
     * Protected method testing if a sheetname is free pr not
     *
     * @param string $sheetname The name
     * @return bool
     */
    protected function sheetNameExists(string $sheetname): bool {
        foreach ($this->getSheet()->getSheetNames() as $existingSheetName) {
            if ($existingSheetName === $sheetname) {
                return true;
            }
        }
        return false;
    }
}