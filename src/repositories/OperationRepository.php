<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/2/2021
 * Time: 8:45 PM
 * Year: 2021
 */

namespace Paysera\CommissionTask\repositories;


interface OperationRepository
{
    public function getAll(): array ;
    public function getPersonCashOutOperationsFromSameWeek(int $persion_id, $date): array ;
}