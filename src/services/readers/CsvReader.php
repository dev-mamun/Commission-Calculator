<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/3/2021
 * Time: 8:56 AM
 * Year: 2021
 */

namespace Paysera\CommissionTask\services\readers;


class CsvReader implements Reader
{
    private $file_path;
    private $delimeter;

    public function __construct(string $file_path, string $delimeter = '')
    {
        $this->setFilePath($file_path);
        $this->setDelimeter($delimeter);
    }

    public function getData(): array
    {
        // TODO: Implement getData() method.
        $results = [];
        $row = 1;
        if (($handle = fopen($this->file_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, $this->delimeter)) !== false) {
                $num = count($data);
                $row++;
                $results[] = $data;
            }
            fclose($handle);
        }

        return $results;
    }

    public function setFilePath(string $file_path)
    {
        if (!file_exists($file_path)) {
            throw new \Exception('Wrong path');
        }

        $this->file_path = $file_path;
    }

    public function setDelimeter(string $delimeter)
    {
        if (empty($delimeter)) {
            $this->delimeter = ',';
        } else {
            $this->delimeter = $delimeter;
        }
    }
}