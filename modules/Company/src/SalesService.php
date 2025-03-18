<?php
declare(strict_types=1);

namespace Modules\Company;

use Modules\Company\Company\VerifiedCompany;

final readonly class SalesService
{
    public function sellTo(VerifiedCompany $company)
    {
        if (!$company->isVerified) {

        }
    }
}
