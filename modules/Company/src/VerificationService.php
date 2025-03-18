<?php
declare(strict_types=1);

namespace Modules\Company;

use Modules\Company\Company\InReviewCompany;
use Modules\Company\Company\RejectedCompany;
use Modules\Company\Company\UnverifiedCompany;
use Modules\Company\Company\VerifiedCompany;

final readonly class VerificationService
{
    public function __construct(private CompaniesHouseClient $companiesHouseClient)
    {

    }

    public function verifyCompany(UnverifiedCompany $company): VerifiedCompany|RejectedCompany|InReviewCompany
    {
        return $company->verify(new CompanyValidator($this->companiesHouseClient));
    }
}
