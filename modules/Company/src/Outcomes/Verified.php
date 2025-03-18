<?php
declare(strict_types=1);

namespace Modules\Company\Outcomes;

use Modules\Company\Company\VerifiedCompany;
use Modules\Company\CompanyType;
use Modules\Company\NotUnverifiedCompany;
use Modules\Company\Outcome;

final readonly class Verified implements Outcome
{
    public function processFor(string $name, string $tradingName, CompanyType $type, array $officers): NotUnverifiedCompany
    {
        return new VerifiedCompany($name, $tradingName, $type, $officers);
    }
}
