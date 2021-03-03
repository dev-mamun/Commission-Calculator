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
use Paysera\CommissionTask\services\CurrencyConverter;


class CashOut extends Commission
{
    const COMMISSION_PERCENT = 0.3;
    const BUSINESS_COMMISSION = 0.5;
    const COMMISSION_MIN_LEGAL = 0.50;
    const TIMES_PER_WEEK = 3;
    const AMOUNT_PER_WEEK = 1000;

    private $repository;

    public function __construct(Operation $operation, OperationRepository $repository)
    {
        parent::__construct($operation);
        $this->repository = $repository;
    }

    public function calculate(): float
    {
        $person_type = $this->operation->getPersonType();
        $commission = "";
        if ($person_type == 'private') {
            $commission = $this->calculateForPrivate();
        } else if ($person_type == 'business') {
            $commission = $this->calculateForBusiness();
        }
        return (float) $commission;
    }

    protected function calculateForPrivate(): float
    {
        $id = $this->operation->getId();
        $person_id = $this->operation->getPersonId();
        $current_date = $this->operation->getDate();
        $current_amount = CurrencyConverter::convertToEur($this->operation->getAmount(), $this->operation->getCurrency());
        $person_operations = $this->repository->getPersonCashOutOperationsFromSameWeek($person_id, $current_date);
        $times_per_week = 0;
        $amount_per_week = 0;
        $discount_id = null;

        foreach ($person_operations as $operation) {
            $times_per_week++;
            if ($times_per_week <= self::TIMES_PER_WEEK) {
                $amount_per_week += CurrencyConverter::convertToEur($operation->getAmount(), $operation->getCurrency());
            }
            if ($amount_per_week >= self::AMOUNT_PER_WEEK) {
                $discount_id = $operation->getId();
                break;
            }
        }
        if (!empty($discount_id)) {
            if ($id == $discount_id) {
                $current_amount = $amount_per_week - self::AMOUNT_PER_WEEK;
            } else if ($id < $discount_id) {
                $current_amount = 0;
            }
        } else {
            $current_amount = 0;
        }
        $commission = $current_amount * self::COMMISSION_PERCENT / 100;
        $converted = CurrencyConverter::convertEur($commission, $this->operation->getCurrency());
        return $converted;
    }

    protected function calculateForBusiness(): float
    {
        $commission = $this->operation->getAmount() * self::BUSINESS_COMMISSION / 100;

        if ($commission < self::COMMISSION_MIN_LEGAL) {
            return self::COMMISSION_MIN_LEGAL;
        }

        return $commission;
    }
}