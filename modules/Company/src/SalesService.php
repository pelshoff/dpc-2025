<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class SalesService
{
    public function sellTo(VerifiedCompany $company)
    {
        if (!$company->isVerified) {

        }
    }
}
