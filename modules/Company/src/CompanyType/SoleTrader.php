<?php
declare(strict_types=1);

namespace Modules\Company\CompanyType;

use Modules\Company\CompanyType;
use Modules\Company\CompanyValidator;

final readonly class SoleTrader implements CompanyType
{

    public function verify(CompanyValidator $validator, array $officers)
    {
        return true;
    }
}
