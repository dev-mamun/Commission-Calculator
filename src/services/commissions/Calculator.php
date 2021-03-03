<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/3/2021
 * Time: 9:33 AM
 * Year: 2021
 */

namespace Paysera\CommissionTask\services\commissions;


use Paysera\CommissionTask\entities\Operation;
use Paysera\CommissionTask\repositories\OperationRepository;


class Calculator
{
    protected $operations;

    public function __construct(OperationRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getStrategy(Operation $operation): Commission
    {
        $operation_name = $operation->getName();

        switch ($operation->getName()) {
            case Operation::CASH_IN:
                $strategy = new CashIn($operation);
                break;
            case Operation::CASH_OUT:
                $strategy = new CashOut($operation, $this->repository);
                break;
            default:
                throw new \Exception("Unknown strategy: " . $operation_name);
                break;
        }
        return $strategy;
    }

    public function calculate(): array
    {
        $results = [];
        foreach ($this->repository->getAll() as $operation) {
            try {
                $calculator = $this->getStrategy($operation);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            $results[] = $this->format($calculator->calculate());
        }
        return $results;
    }

    protected function format($result): string
    {
        $rounded = ceil($result * 100) / 100;
        $formatted_result = number_format((float)$rounded, 2, '.', '');
        return $formatted_result;
    }
}