<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/3/2021
 * Time: 8:52 AM
 * Year: 2021
 */

namespace Paysera\CommissionTask\services;


class CurrencyConverter
{
    const EUR_CONVERSION = [
        'EUR' => 1,
        'USD' => 1.1497,
        'JPY' => 129.53,
    ];

    public static function convertEur($amount, $currency): float
    {
        $result = $amount * self::EUR_CONVERSION[$currency];

        return (float)$result;
    }

    public static function convertToEur($amount, $currency): float
    {
        $result = $amount / self::EUR_CONVERSION[$currency];

        return (float)$result;
    }
}