<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/3/2021
 * Time: 9:32 AM
 * Year: 2021
 */

namespace Paysera\CommissionTask\services\commissions;

use Paysera\CommissionTask\entities\Operation;
use Paysera\CommissionTask\services\commissions\Commission;


class CashIn extends Commission
{
    protected $operation;

    const COMMISSION_PERCENT = 0.03;
    const COMMISSION_MAX = 5;

    public function calculate(): float
    {
        $commission = $this->operation->getAmount() * self::COMMISSION_PERCENT / 100;

        if ($commission > self::COMMISSION_MAX) {
            return self::COMMISSION_MAX;
        }

        return $commission;
    }
}