<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/2/2021
 * Time: 8:43 PM
 * Year: 2021
 */

namespace Paysera\CommissionTask\repositories;

use Paysera\CommissionTask\entities\Operation;
use Paysera\CommissionTask\repositories\OperationRepository;

class MemoryOperationRepository implements OperationRepository
{
    protected $operations;

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
        return $this->operations;
    }

    public function add(Operation $operation)
    {
        $this->operations[] = $operation;
    }

    public function getPersonCashOutOperationsFromSameWeek(int $person_id, $date): array
    {
        $operations = [];
        $current_date = new \DateTime($date);
        $current_week = $current_date->format('W');

        foreach ($this->operations as $operation) {
            $operation_date = new \DateTime($operation->getDate());
            $operation_week = $operation_date->format('W');
            if ($operation->getPersonId() == $person_id && $operation->getName() == Operation::CASH_OUT) {
                if ($current_week == $operation_week && abs($current_date->diff($operation_date)->format('%R%a')) <= 7) {
                    $operations[] = $operation;
                } else if ($current_week < $operation_week) {
                    break;
                }
            }
        }
        return $operations;
    }
}