<?php
require_once 'SpreadsheetReader.php';
class SpreadsheetReaderFactory {
    private function __construct() {
        throw new Exception('Could not allocate an instance of ' . __CLASS__);
    }

    private static $classNameMap = array(
        'xls' => array(
            'name' => 'SpreadsheetReader_Excel',
            'path' => 'Excel/SpreadsheetReader_Excel'
        ),
        'ods' => array(
            'name' => 'SpreadsheetReader_OpenDocumentSheet',
            'path' => 'OpenDocumentSheet/SpreadsheetReader_OpenDocumentSheet'
        )
    );

    /**
     *
     * @param   $filePath, $filePath of spreadsheet file, or $extName of spreadsheet.
     *          example: 'test.xls', or just 'xls'.
     *
     * @return  an instance of reader.
     * @access  public
     * @static
     */
    public static function &reader($filePath) {
        $returnFalse = FALSE;

        if (is_readable($filePath))
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        else if (isset(self::$classNameMap[$filePath]))
            $ext = $filePath;
        else
            return $returnFalse;

        if (isset(self::$classNameMap[$ext]['name'])) {
            $className = self::$classNameMap[$ext]['name'];
            require_once dirname(__FILE__) . '/' . self::$classNameMap[$ext]['path'] . '.php';
        }
        else {
            $className = 'SpreadsheetReader';
        }
        $sheetReader = new $className;
        return $sheetReader;
    }
}
?>