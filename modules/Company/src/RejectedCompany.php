<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class RejectedCompany
{
    public function __construct(
        public string $name,
        public string $tradingName,
        public CompanyType $type
    )
    {
    }
}
