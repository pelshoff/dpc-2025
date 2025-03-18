<?php
declare(strict_types=1);

namespace Modules\Company\CompanyType;

use Modules\Company\CompanyType;
use Modules\Company\CompanyValidator;
use Modules\Company\Outcome;

final readonly class Llp implements CompanyType
{
    public function __construct(public string $registrationNumber)
    {

    }

    public function verify(CompanyValidator $validator, array $officers): Outcome
    {
        return $validator->verify($this->registrationNumber, $officers);
    }
}
