<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class VerificationService
{
    public function __construct(private CompaniesHouseClient $companiesHouseClient)
    {

    }

    public function verifyCompany(Company $company)
    {
        if ($company->type === CompanyType::SoleTrader) {
            return;
        }
        $this->companiesHouseClient->getCompanyProfile($company->registrationNumber);
        $this->companiesHouseClient->listOfficers($company->registrationNumber);
    }
}
