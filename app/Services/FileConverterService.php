<?php
/**
 * Created by PhpStorm.
 * User: eggy
 * Date: 8/8/18
 * Time: 6:24 PM
 */

namespace App\Services;


class FileConverterService
{
    /**
     * @param string $filename
     * @param string $delimiter
     * @return array|bool
     */
    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}