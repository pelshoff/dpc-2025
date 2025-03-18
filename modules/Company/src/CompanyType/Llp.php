<?php
declare(strict_types=1);

namespace Modules\Company\CompanyType;

use Modules\Company\CompaniesHouseClient;
use Modules\Company\CompanyType;
use Modules\Company\CompanyValidator;

final readonly class Llp implements CompanyType
{
    public function __construct(public string $registrationNumber)
    {

    }

    public function verify(CompanyValidator $validator, array $officers): bool
    {
        return $validator->verify($this->registrationNumber, $officers);
    }
}
