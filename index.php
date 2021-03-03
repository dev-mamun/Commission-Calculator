<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: mamun1214@gmail.com
 * Date: 3/1/2021
 * Time: 2:57 PM
 * Year: 2021
 */

use Paysera\CommissionTask\services\readers\CsvReader;

require_once "vendor/autoload.php";


$filePath = "input.csv";
$reader = new CsvReader($filePath);