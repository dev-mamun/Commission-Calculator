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

abstract class Commission
{
    protected $operation;

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    abstract public function calculate();

}