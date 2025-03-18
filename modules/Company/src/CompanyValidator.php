<?php
declare(strict_types=1);

namespace Modules\Company;

use Modules\Company\Outcomes\InReview;
use Modules\Company\Outcomes\Rejected;
use Modules\Company\Outcomes\Verified;

final readonly class CompanyValidator
{
    public function __construct(private CompaniesHouseClient $client)
    {

    }

    /**
     * @param string $registrationNumber
     * @param array<int, Officer> $companyOfficers
     */
    public function verify(string $registrationNumber, array $companyOfficers): Outcome
    {
        if ($this->client->getCompanyProfile($registrationNumber) === null) {
            return new Rejected();
        }
        $officers = $this->client->listOfficers($registrationNumber);
        if (count($companyOfficers) > count($officers)) {
            return new Rejected();
        }
        foreach ($companyOfficers as $companyOfficer) {
            if (!$companyOfficer->isOnTheListOf($officers)) {
                return new InReview();
            }
        }
        return new Verified();
    }
}
