<?php
declare(strict_types=1);

namespace Modules\Company;

interface CompaniesHouseClient
{
    public function getCompanyProfile(string $companyNumber);

    public function listOfficers(string $companyNumber);
}
