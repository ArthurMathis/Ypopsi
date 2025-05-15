<?php

namespace App\Core\Tools\FileManager;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

/**
 * Class writing in a file
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class FilePrinter {
    /**
     * Protected attribute containing the writer
     *
     * @var Xlsx
     */
    protected Xlsx $writer; 
    /**
     * Protected attribute containing the file
     *
     * @var SpreadSheet
     */
    protected SpreadSheet $sheet; 
    /**
     * Protected attribute containing the page
     *
     * @var Worksheet
     */
    protected Worksheet $work_sheet; 

    /**
     * Constructor class 
     *
     * @param string $path The path of the file
     */
    public function __construct(protected string $path) {
        $this->sheet = file_exists($this->getPath()) ? IOFactory::load($this->getpath()) : new Spreadsheet(); 
        $this->writer = new Xlsx($this->getSheet());                                                                               // Opening the writer
        
        $title = "Insertion du " . date('d/m/Y');
        $title = $this->addSheet($title);                                                                               // Creating the new sheet 

        $this->work_sheet = $this->getSheet()->getActiveSheet();
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
     * @return SpreadSheet
     */
    public function getSheet(): SpreadSheet { return $this->sheet; }
    /**
     * Public method returning the page
     *
     * @return Worksheet
     */
    public function getWorkSheet(): Worksheet { return $this->work_sheet; }
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
     * @param int $row The index of the row
     * @param array $data The data to write
     * @return void
     */
    public function printRow(int $row, array &$data) {
        $work_sheet = $this->getWorkSheet();
        $column = FilePrinter::getBasedColumn();

        foreach($data as $obj) {
            $work_sheet->setCellValue($column . $row, $obj);
            $column++;
        }
    }

    // * SAVING * //
    /**
     * Public method registering the modifications
     *
     * @return void
     */
    public function save() { $this->getWriter()->save($this->getPath()); 
    
        $file = basename($this->getPath());
        echo "Sauvegarde du fichier <b>$file</b> effectuée.";
    }

    // * SHEET MANAGEMENT * //
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

        $worksheet = new Worksheet($this->getSheet(), $sheetname);
        $this->getSheet()->addSheet($worksheet);
        $worksheet->setTitle($sheetname);

        $this->getSheet()->setActiveSheetIndexByName($sheetname);
        $this->removeDefaultSheet();

        return $sheetname;
    }

    /**
     * Protected method testing if a sheetname is free or not
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

    /**
     * Protected method removing the default sheet if it exists
     *
     * @return void
     */
    protected function removeDefaultSheet() {
        $defaultSheetName = 'Worksheet';
        $sheetNames = $this->getSheet()->getSheetNames();

        if (in_array($defaultSheetName, $sheetNames)) {
            $sheetIndex = array_search($defaultSheetName, $sheetNames);
            $this->getSheet()->removeSheetByIndex($sheetIndex);
        }
    }
}