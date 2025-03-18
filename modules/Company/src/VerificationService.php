<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class VerificationService
{
    public function __construct(private CompaniesHouseClient $companiesHouseClient)
    {

    }

    public function verifyCompany(UnverifiedCompany $company): VerifiedCompany|RejectedCompany
    {
        return $company->verify(new CompanyValidator($this->companiesHouseClient));
    }
}
