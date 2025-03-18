<?php
declare(strict_types=1);

namespace Modules\Company\Company;

use Modules\Company\CompanyType;
use Modules\Company\CompanyValidator;
use Modules\Company\NotUnverifiedCompany;
use Modules\Company\Officer;

final readonly class UnverifiedCompany
{
    public function __construct(
        public string $name,
        public string $tradingName,
        public CompanyType $type,
        /** @var $officers array<int, Officer> */
        public array $officers,
    )
    {
    }

    public function verify(CompanyValidator $validator): NotUnverifiedCompany
    {
        $outcome = $this->type->verify($validator, $this->officers);
        return $outcome->processFor($this->name, $this->tradingName, $this->type, $this->officers);
    }
}
