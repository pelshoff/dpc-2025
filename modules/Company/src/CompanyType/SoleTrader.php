<?php
declare(strict_types=1);

namespace Modules\Company\CompanyType;

use Modules\Company\CompanyType;
use Modules\Company\CompanyValidator;
use Modules\Company\Outcome;
use Modules\Company\Outcomes\Verified;

final readonly class SoleTrader implements CompanyType
{
    public function verify(CompanyValidator $validator, array $officers): Outcome
    {
        return new Verified();
    }
}
