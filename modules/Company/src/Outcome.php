<?php
declare(strict_types=1);

namespace Modules\Company;

interface Outcome
{
    public function processFor(string $name, string $tradingName, CompanyType $type, array $officers): NotUnverifiedCompany;
}
