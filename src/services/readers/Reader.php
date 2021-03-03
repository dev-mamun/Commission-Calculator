<?php
/**
 * Created by Md.Abdullah Al Mamun.
 * Email: dev.mamun@gmail.com
 * Date: 3/3/2021
 * Time: 8:56 AM
 * Year: 2021
 */

namespace Paysera\CommissionTask\services\readers;


interface Reader
{
    public function getData(): array;
}