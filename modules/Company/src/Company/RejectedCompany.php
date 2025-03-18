<?php
declare(strict_types=1);

namespace Modules\Company\Company;

use Modules\Company\CompanyType;
use Modules\Company\NotUnverifiedCompany;

final readonly class RejectedCompany implements NotUnverifiedCompany
{
    public function __construct(
        public string $name,
        public string $tradingName,
        public CompanyType $type
    )
    {
    }
}
