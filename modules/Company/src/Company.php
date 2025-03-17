<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class Company
{
    public function __construct(
        public string $name,
        public string $tradingName,
        public CompanyType $type,
        public ?string $registrationNumber
    )
    {
    }
}
