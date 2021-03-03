<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: mamun1214@gmail.com
 * Date: 3/1/2021
 * Time: 2:57 PM
 * Year: 2021
 */

require_once "vendor/autoload.php";


use Paysera\CommissionTask\entities\Operation;
use Paysera\CommissionTask\Services\Readers\CsvReader;
use Paysera\CommissionTask\services\commissions\Calculator;
use Paysera\CommissionTask\repositories\MemoryOperationRepository as OSRepository;

$filePath = "inputs.csv";

$repository = new OSRepository();

$reader = new CsvReader($filePath);
$inputs = $reader->getData();
//var_dump($inputs);
$id = 1;
foreach ($inputs as $row) {
    $operation = new Operation();
    $operation->setId($id++);
    $operation->setDate($row[0]);
    $operation->setPersonId((int) $row[1]);
    $operation->setPersonType($row[2]);
    $operation->setName($row[3]);
    $operation->setAmount($row[4]);
    $operation->setCurrency($row[5]);

    $repository->add($operation);
}

$calculator = new Calculator($repository);
$results = $calculator->calculate();

foreach ($results as $result) {
    echo $result."<br>";
}