<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class CompanyValidator
{
    public function __construct(private CompaniesHouseClient $client)
    {

    }

    /**
     * @param string $registrationNumber
     * @param array<int, Officer> $companyOfficers
     * @return bool
     */
    public function verify(string $registrationNumber, array $companyOfficers)
    {
        if ($this->client->getCompanyProfile($registrationNumber) === null) {
            return false;
        }
        $officers = $this->client->listOfficers($registrationNumber);
        foreach ($companyOfficers as $companyOfficer) {
            if (!$companyOfficer->isOnTheListOf($officers)) {
                return false;
            }
        }
        return true;
    }
}
