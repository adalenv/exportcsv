<?php 

namespace Daveismyname\ExportCsv;

/**
 * Class to generate CSV from array
 * adapted from https://www.codexworld.com/export-data-to-csv-file-using-php-mysql/
 */
class ExportCsv
{
    /**
     * CSV export
     * @param  array  $headerFields array of column names
     * @param  array  $records      array of records
     * @param  string $filename     name of the file including .csv
     * @param  string $delimiter    set the delimiter
     * @return download             csv file
     */
    public function __construct(array $headerFields, array $records, string $filename, string $delimiter = ',')
    {
        //create a file pointer
        $f = fopen('php://memory', 'w');
        
        //set column headers
        fputcsv($f, $headerFields, $delimiter);
        
        foreach($records as $row) {
            //output each row of the data,
            fputcsv($f, array_values($row), $delimiter);
        }

        //move back to beginning of file
        fseek($f, 0);
        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        
        //output all remaining data on a file pointer
        fpassthru($f);
    }

}
